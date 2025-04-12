$("#curriculum").load("findcurriculum.php?keresett=");

document.getElementById("search-box").addEventListener('keyup', (e) => {
    var ertek = e.target.value.trim();

    if (ertek === "") {
        document.getElementById("curriculum").innerHTML = "<p>Kérlek, adj meg egy keresési kifejezést!</p>";
        return;
    }

    $("#curriculum").load("findcurriculum.php?keresett=" + ertek);
});
