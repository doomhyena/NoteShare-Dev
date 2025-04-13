$("#curriculum").load("/NoteShare/assets/php/findcurriculum.php?keresett=");

document.getElementById("search-box").addEventListener('keyup', (e) => {
        
    var ertek = e.target.value;
        
    $("#curriculum").load("/NoteShare/assets/php/findcurriculum.php?keresett="+ertek);
        
});