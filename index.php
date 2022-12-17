<?php
ini_set('display_errors', 1);


require __DIR__ . "/vendor/autoload.php";

$clientId = "267029756361-dqo3qdi1pgp96c9aar0bttnbfnn4f840.apps.googleusercontent.com";
$clientSecret = "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";
$returnUrl = "http://localhost/login-google/index.php";

$client = new Google_Client();
$client->setClientId($clientId);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($returnUrl);

$client->addScope("email");
$client->addScope("profile");



?>
<script src="https://kit.fontawesome.com/c17f5ac32f.js" crossorigin="anonymous"></script>
<style>
    form {
        margin: 25px auto;
        width: 500px;
    }

    form>div {
        display: flex;
        flex-direction: column;
    }

    form>div>label {
        font-size: 18px;
    }

    form>div>input {
        margin: 10px 0;
        padding: 10px 7px;
        font-size: 17px;
    }

    form>div+div {
        margin: 20px 0;
    }

    form>button {
        all: unset;
        background-color: dodgerblue;
        padding: 10px 15px;
        color: white;
    }

    .anotherLogin {
        margin: 25px auto;
        width: 500px;
    }

    .google {
        display: flex;
        gap: 0 15px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        padding: 15px 25px;
        border-radius: 7px;
        background-color: darkred;
        cursor: pointer;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
</style>




<?php
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info 
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

?>

    <img src="<?= $google_account_info->picture ?>" alt="">
    <h3>İsim : <?= $name; ?></h3>
    <h3>Email : <?= $email; ?></h3>

<?php

} else {
?>
    <form action="/" method="post">
        <div>
            <label>İsim</label>
            <input type="text">
        </div>
        <div>
            <label>E-posta</label>
            <input type="email">
        </div>
        <div>
            <label>Şifre</label>
            <input type="password">
        </div>
        <button>Kayıt Ol</button>
    </form>

    <div class="anotherLogin">
        <a href="<?= $client->createAuthUrl() ?>">
            <div class="google">
                <span>
                    Google İle Giriş Yap
                </span>
                <i class="fa-brands fa-google"></i>
            </div>
        </a>

    </div>
<?php
}
?>