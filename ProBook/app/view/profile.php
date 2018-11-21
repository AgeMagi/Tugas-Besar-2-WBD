<?php
        render('header.php');
?>
<title>Profile</title>
<link rel="stylesheet" href="/static/css/profile.css">
<div class="main-container">
    <div class="profile-picture-jumbotron">
        <div class="profile-picture-container">
        </div>
        <div class="profile-picture-container">
            <img src="<?= $user->imgPath ?>" class="profile-img">
            <h1 class="profile-name" id="profile_name"><?php echo $user->fullname ?></h1>
        </div>
        <div class="profile-picture-container">
            <a href="/profile/edit/"><img src="/static/img/pencil.png" class="edit-icon"></a>
        </div>
    </div>

    <div class="detail-container">
        <h1 class="table-headline">My Profile</h1>
        <table class="profile-table" cellpadding="15">
            <tr class="table-row" height=75>
                <td width="10%" ><img class="profile-icon" src="/static/img/profile.png"></td>
                <td width="40%">Username</td>
                <td id="username_column"><?= $user->username ?></td>
            </tr>
            <tr class="table-row" height=75>
                <td><img class="profile-icon" src="/static/img/email.png"></td>
                <td>Email</td>
                <td id="email_column"><?= $user->email ?></td>
            </tr>
            <tr class="table-row" height=75>
                <td><img class="profile-icon" src="/static/img/house.png"></td>
                <td>Address</td>
                <td id="address_column"><?= $user->address  ?></td>
            </tr>
            <tr class="table-row" height=75>
                <td><img class="profile-icon" src="/static/img/phone.png"></td>
                <td>Phone Number</td>
                <td id="phone_column"><?= $user->phone ?></td>
            </tr>
        </table>
    </div>
</div>

<?php
    include __STATIC__.'/html/footer.html';
?>