<?php
/**
 * Created by PhpStorm.
 * User: adylan
 * Date: 24/10/18
 * Time: 15:17
 */
    render('header.php');
?>

<meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="/static/css/edit-profile.css">
<body>
<form class="edit-profile-container content" action="/profile/edit/" method="POST" enctype="multipart/form-data">
    <h1 class="edit-profile-headline">Edit Profile</h1>
    <div class="edit-profile-content">
        <div class="edit-profile-picture">
            <img src="<?= $user->imgPath ?>" class="edit-picture-img" alt="Profile Picture">
            <div class="edit-picture-input">
                <span class="image-upload-label" >Update profile picture</span>
                <input type="file" id="profile_picture" name="profile_picture" class="picture-input-file" >
            </div>
        </div>
        <div class="edit-profile-identity">
            <div class="row">
                <span class="identity-column" >Name </span>
                <input type="text" class="input-column" id="edit_name" name="fullname" value="<?= $user->fullname?>">
            </div>
            <div class="row">
                <span class="identity-column">Address </span>
                <textarea class="input-column" rows="10" id="edit_address" name="address"  value=""><?= $user->address?></textarea>
            </div>
            <div class="row">
                <span class="identity-column">Phone Number </span>
                <input type="text" class="input-column" id="edit_phone" name="phone" value="<?= $user->phone ?>">
            </div>
        </div>

        <div class="edit-button-container">
            <button class="edit-button orange-button" id="back_button">BACK</button>
            <input class="edit-button blue-button" type="submit" id="save_button" value="SAVE">
        </div>
    </div>
</form>
</body>

<script src="/static/js/edit-profile.js"></script>
<?php
    include __STATIC__.'/html/footer.html';
?>