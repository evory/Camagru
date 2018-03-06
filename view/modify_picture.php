<link rel="stylesheet" href="../view/css/style.css">

<h1>Modify your picture</h1>
<br>
<form method="post" action="/home/modify_picture" enctype="multipart/form-data" class="stickers_div">
    <label for="filter1"><img src="http://localhost:8080/view/stickers/beer.png" alt="Filtre 1" class="stickers_img" /><input type="radio" id="filter1" name="overlay" value="1"></label>
    <label for="filter2"><img src="http://localhost:8080/view/stickers/jo.png" alt="Filtre 2" class="stickers_img" /><input type="radio" id="filter2" name="overlay" value="2"></label>
    <label for="filter3"><img src="http://localhost:8080/view/stickers/grass.png" alt="Filtre 3" class="stickers_img" /><input type="radio" id="filter3" name="overlay" value="3"></label>
    <input type="submit" name="sendsticker" value="Envoyer" id="sendsticker"/>
</form>
