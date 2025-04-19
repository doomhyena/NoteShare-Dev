$("#search").load("/NoteShare/assets/php/findanything.php?keresett=");

document.getElementById("search-box").addEventListener('keyup', (e) => {
        
    var ertek = e.target.value;
        
    $("#search").load("/NoteShare/assets/php/findanything.php?keresett="+ertek);
        
});