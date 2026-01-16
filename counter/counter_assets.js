document.addEventListener("DOMContentLoaded", function () {

  if (typeof addressDatabase === "undefined") {
    alert("addressDatabase.js লোড হয়নি");
    return;
  }

  const upazilaSel = document.getElementById("upazila");
  const unionSel   = document.getElementById("union");
  const wardSel    = document.getElementById("ward");
  const villageSel = document.getElementById("village");

  function reset(sel, text) {
    sel.innerHTML = `<option value="">${text}</option>`;
  }

  reset(upazilaSel, "উপজেলা নির্বাচন করুন");
  reset(unionSel, "ইউনিয়ন নির্বাচন করুন");
  reset(wardSel, "ওয়ার্ড নির্বাচন করুন");
  reset(villageSel, "গ্রাম নির্বাচন করুন");

  /* ---------- UPAZILA ---------- */
  Object.keys(addressDatabase.upazilas).forEach(upKey => {
    const up = addressDatabase.upazilas[upKey];
    upazilaSel.add(new Option(up.bn || upKey, upKey));
  });

  /* ---------- UNION ---------- */
  upazilaSel.onchange = () => {
    reset(unionSel, "ইউনিয়ন নির্বাচন করুন");
    reset(wardSel, "ওয়ার্ড নির্বাচন করুন");
    reset(villageSel, "গ্রাম নির্বাচন করুন");

    const up = addressDatabase.upazilas[upazilaSel.value];
    if (!up) return;

    Object.keys(up.unions || {}).forEach(unKey => {
      unionSel.add(new Option(up.unions[unKey].bn || unKey, unKey));
    });
  };

  /* ---------- WARD ---------- */
  unionSel.onchange = () => {
    reset(wardSel, "ওয়ার্ড নির্বাচন করুন");
    reset(villageSel, "গ্রাম নির্বাচন করুন");

    const up = addressDatabase.upazilas[upazilaSel.value];
    const un = up?.unions?.[unionSel.value];
    if (!un) return;

    Object.keys(un.wards || {}).forEach(wKey => {
      wardSel.add(new Option(un.wards[wKey].bn || wKey, wKey));
    });
  };

  /* ---------- VILLAGE (FIXED) ---------- */
  wardSel.onchange = () => {
    reset(villageSel, "গ্রাম নির্বাচন করুন");

    const up = addressDatabase.upazilas[upazilaSel.value];
    const un = up?.unions?.[unionSel.value];
    const wd = un?.wards?.[wardSel.value];
    if (!wd || !wd.villages) return;

    /* villages OBJECT handle */
    Object.keys(wd.villages).forEach(vKey => {
      const v = wd.villages[vKey];
      villageSel.add(new Option(v.bn || v.en || vKey, vKey));
    });
  };

});
