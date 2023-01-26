<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ShortUrl.php';

if (!empty($_GET['t'])) {
    \classes\ShortUrl::catchUrl($_GET['t']);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
?>
<section class="main">
    <div class="wrapper">
        <form method="POST" action="/ajax.php">
            <label for="url">URL</label>
            <input id="url" name="url" type="text">
            <button type="submit">
                <a type="submit" class="border-button">Cut!</a>
            </button>
        </form>
        <p class="response">
        </p>
    </div>
</section>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
