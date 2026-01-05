document.getElementById("formAkun").addEventListener("submit", function(e){
    e.preventDefault();

    const nama = document.getElementById("nama").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    fetch("register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            nama: nama,
            email: email,
            password: password
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success") {

            // SET STATUS LOGIN
            localStorage.setItem("isLogin", "true");
            
            // Simpan ke localStorage untuk tampil di profil.html
            localStorage.setItem("nama", nama);
            localStorage.setItem("email", email);

            // Redirect ke profil.html
            window.location.href = "profil.html";
        } else {
            alert("Gagal: " + data.message);
        }
    });
});
