document.addEventListener('DOMContentLoaded', () => {

/* ---------------- PATIENT SEARCH ---------------- */
const mobileInput = document.getElementById('patient-mobile');
const nameInput   = document.getElementById('patient-name');
const suggestionBox = document.getElementById('patient-suggestions');

if (mobileInput) {
  mobileInput.addEventListener('keyup', () => {
    const q = mobileInput.value.trim();
    suggestionBox.innerHTML = '';

    if (q.length < 3) return;

    fetch(`ajax/search_patient.php?q=${encodeURIComponent(q)}`)
      .then(res => res.json())
      .then(data => {
        if (data.length === 0) return;

        data.forEach(p => {
          const div = document.createElement('div');
          div.className = 'suggest-item';
          div.textContent = `${p.name} (${p.mobile})`;
          div.onclick = () => {
            mobileInput.value = p.mobile;
            nameInput.value   = p.name;
            document.getElementById('patient-age').value = p.age ?? '';
            document.getElementById('patient-gender').value = p.gender ?? '';
            document.getElementById('patient-blood').value = p.blood_group ?? '';
            suggestionBox.innerHTML = '';
          };
          suggestionBox.appendChild(div);
        });
      });
  });
}

/* ---------------- TEST SEARCH ---------------- */
const testInput = document.getElementById('test-search');
const testBox   = document.getElementById('test-suggestions');
const selected  = document.getElementById('selected-tests');
const totalInp  = document.getElementById('total');

let total = 0;

if (testInput) {
  testInput.addEventListener('keyup', () => {
    const q = testInput.value.trim();
    testBox.innerHTML = '';
    if (q.length < 1) return;

    fetch(`ajax/search_test.php?q=${encodeURIComponent(q)}`)
      .then(res => res.json())
      .then(data => {
        if (data.length === 0) {
          testBox.innerHTML = '<div class="suggest-item">কোন টেস্ট পাওয়া যায়নি</div>';
          return;
        }

        data.forEach(t => {
          const div = document.createElement('div');
          div.className = 'suggest-item';
          div.textContent = `${t.test_name} — ৳${t.price}`;
          div.onclick = () => addTest(t);
          testBox.appendChild(div);
        });
      });
  });
}

function addTest(t) {
  const row = document.createElement('div');
  row.className = 'selected-test';
  row.innerHTML = `${t.test_name} — ৳${t.price} <button>x</button>`;

  row.querySelector('button').onclick = () => {
    total -= parseFloat(t.price);
    updateTotal();
    row.remove();
  };

  selected.appendChild(row);
  total += parseFloat(t.price);
  updateTotal();

  testInput.value = '';
  testBox.innerHTML = '';
}

function updateTotal() {
  totalInp.value = total.toFixed(2);
  calculatePayable();
}

/* ---------------- DISCOUNT LOGIC ---------------- */
const discPercent = document.getElementById('discount-percent');
const discAmount  = document.getElementById('discount-amount');
const payableInp  = document.getElementById('payable');

let lock = false;

function calculatePayable() {
  const dAmt = parseFloat(discAmount.value) || 0;
  payableInp.value = (total - dAmt).toFixed(2);
}

discPercent.addEventListener('input', () => {
  if (lock) return;
  lock = true;
  const p = parseFloat(discPercent.value) || 0;
  discAmount.value = ((total * p) / 100).toFixed(2);
  calculatePayable();
  lock = false;
});

discAmount.addEventListener('input', () => {
  if (lock) return;
  lock = true;
  const a = parseFloat(discAmount.value) || 0;
  discPercent.value = total ? ((a / total) * 100).toFixed(2) : 0;
  calculatePayable();
  lock = false;
});

});
