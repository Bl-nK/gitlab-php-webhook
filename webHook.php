<?php
ignore_user_abort(true);

//Variable must be changed to match the branch which you are wanting to watch.
$branch = "master";

if (file_get_contents("php://input")) {
	// Gitlab sends json via HTTP_RAW_POST_DATA
	$postData = json_decode(file_get_contents("php://input"));
	/* ref is a field within the json that holds branch information. The string is turned into an array using explode.
	After transformation, the last item of the array (the branch name) is used as the value for $refData */
	$refData = explode("/",$postData->ref);
	$refBranch = array_pop($refData);

	if ($refBranch == $branch) {
		//Make sure we are using the correct branch
		`git checkout $branch`;
		//Pull latest changes
		`git pull`;
	}
} else {
	throw new Exception("HTTP_RAW_POST_DATA is Empty. Client IP is" . $_SERVER["REMOTE_ADDR"]);
}
?>
