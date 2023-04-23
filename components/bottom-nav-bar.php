<?php
$userRef = $database->getReference('users/' . $user_id);
$userSnapshot = $userRef->getSnapshot();
$fetch_profile = $userSnapshot->getValue();
?>
<div class="icons">
	<div class="icon" onclick="window.location.href = 'index.php';">
		<i class="fa fa-home"></i>
		<span>Home</span>
	</div>
	<div class="icon" onclick="window.location.href = 'triphistory.php';">
		<i class="fa fa-history"></i>
		<span>History</span>
	</div>
	<div class="icon" onclick="window.location.href = 'profile.php';">
		<i class="fa fa-user"></i>
		<span>Profile</span>
	</div>
	<div class="icon" onclick="window.location.href = 'contactus.php';">
		<i class="fa fa-phone"></i>
		<span>Contact</span>
	</div>
</div>