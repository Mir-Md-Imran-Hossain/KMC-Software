document.addEventListener("DOMContentLoaded", function () {
  const up = document.getElementById("upazila");
  const un = document.getElementById("union");
  const wd = document.getElementById("ward");
  const vl = document.getElementById("village");

  if (!up || !un || !wd || !vl) return;

  function disableAll() {
    un.disabled = true;
    wd.disabled = true;
    vl.disabled = true;
  }

  function reset(sel, txt) {
    sel.innerHTML = `<option value="">${txt}</option>`;
  }

  disableAll();

  up.onchange = () => {
    reset(un, "ইউনিয়ন নির্বাচন করুন");
    reset(wd, "ওয়ার্ড নির্বাচন করুন");
    reset(vl, "গ্রাম নির্বাচন করুন");
    un.disabled = false;
    wd.disabled = true;
    vl.disabled = true;
  };

  un.onchange = () => {
    reset(wd, "ওয়ার্ড নির্বাচন করুন");
    reset(vl, "গ্রাম নির্বাচন করুন");
    wd.disabled = false;
    vl.disabled = true;
  };

  wd.onchange = () => {
    reset(vl, "গ্রাম নির্বাচন করুন");
    vl.disabled = false;
  };
});
