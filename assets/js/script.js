document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("search-box").addEventListener('keyup', (e) => {
        var ertek = e.target.value;
        $("#search").html("Keresés folyamatban...");
        $("#search").load("assets/php/findanything.php?keresett=" + encodeURIComponent(ertek));
    });
});