// Ambil data
document.getElementById("namaUser").textContent = localStorage.getItem("nama");
document.getElementById("emailUser").textContent = localStorage.getItem("email");

// Logout
document.getElementById("logoutBtn").addEventListener("click", function () {
    localStorage.clear();
    window.location.href = "akun.html";
});
