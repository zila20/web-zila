// =========================
// Script Grand Hotel
// =========================

// 🔔 Notifikasi sukses pemesanan
function confirmBooking(e) {
  e.preventDefault();
  alert("✅ Pemesanan berhasil dikirim!");
}

// 🔽 Scroll halus ke section "About Us"
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function(e) {
    e.preventDefault();
    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth"
    });
  });
});
