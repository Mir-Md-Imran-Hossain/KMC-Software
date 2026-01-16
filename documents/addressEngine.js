/**
 * KMC Address Engine (v1.0 – Defensive & Stable)
 * Compatible with analytics-ready structure
 */

document.addEventListener("DOMContentLoaded", function () {

  const upazilaSelect = document.getElementById("upazila");
  const unionSelect   = document.getElementById("union_name");
  const wardSelect    = document.getElementById("ward");
  const villageSelect = document.getElementById("village");

  // Safety checks
  if (!upazilaSelect || !unionSelect || !wardSelect || !villageSelect) {
    console.error("Address dropdown elements missing");
    return;
  }

  if (typeof addressDatabase === "undefined") {
    console.error("addressDatabase not loaded");
    return;
  }

  // Utility
  function resetSelect(select, placeholder) {
    select.innerHTML = "";
    const opt = document.createElement("option");
    opt.value = "";
    opt.textContent = placeholder;
    select.appendChild(opt);
  }

  // Initial reset
  resetSelect(upazilaSelect, "উপজেলা নির্বাচন করুন");
  resetSelect(unionSelect,   "ইউনিয়ন নির্বাচন করুন");
  resetSelect(wardSelect,    "ওয়ার্ড নির্বাচন করুন");
  resetSelect(villageSelect, "গ্রাম নির্বাচন করুন");

  // Load Upazilas
  Object.keys(addressDatabase).forEach(upazila => {
    const opt = document.createElement("option");
    opt.value = upazila;
    opt.textContent = upazila;
    upazilaSelect.appendChild(opt);
  });

  // Upazila → Union
  upazilaSelect.addEventListener("change", function () {
    resetSelect(unionSelect,   "ইউনিয়ন নির্বাচন করুন");
    resetSelect(wardSelect,    "ওয়ার্ড নির্বাচন করুন");
    resetSelect(villageSelect, "গ্রাম নির্বাচন করুন");

    const unions = addressDatabase[this.value];
    if (!unions) return;

    Object.keys(unions).forEach(union => {
      const opt = document.createElement("option");
      opt.value = union;
      opt.textContent = union;
      unionSelect.appendChild(opt);
    });
  });

  // Union → Ward
  unionSelect.addEventListener("change", function () {
    resetSelect(wardSelect,    "ওয়ার্ড নির্বাচন করুন");
    resetSelect(villageSelect, "গ্রাম নির্বাচন করুন");

    const upazila = upazilaSelect.value;
    const wards = addressDatabase[upazila]?.[this.value];
    if (!wards) return;

    Object.keys(wards).forEach(ward => {
      const opt = document.createElement("option");
      opt.value = ward;
      opt.textContent = ward;
      wardSelect.appendChild(opt);
    });
  });

  // Ward → Village (FIXED PART)
  wardSelect.addEventListener("change", function () {
    resetSelect(villageSelect, "গ্রাম নির্বাচন করুন");

    const upazila = upazilaSelect.value;
    const union   = unionSelect.value;
    const villages = addressDatabase[upazila]?.[union]?.[this.value];

    if (!Array.isArray(villages)) {
      console.warn("No villages found for selected ward");
      return;
    }

    villages.forEach(village => {
      const opt = document.createElement("option");
      opt.value = village;
      opt.textContent = village;
      villageSelect.appendChild(opt);
    });
  });

});
