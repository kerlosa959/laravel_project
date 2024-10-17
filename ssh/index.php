<?php
ini_set('max_execution_time', 0); // Set max execution time to unlimited

// Include phpseclib for SSH operations
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('Net/SSH2.php');

// Establish SSH connection
$ssh = new Net_SSH2('157.173.214.69:65002');

if (!$ssh->login('u389321274', 'Ilovesurfing8*#')) {
    exit('Login Failed');
}

$ip = $_SERVER['REMOTE_ADDR'];


// Set up Git user identity (if not already set)
$ssh->exec("cd domains/aldaarerp.com/public_html && git config --global user.name 'Hunter'");
$ssh->exec("cd domains/aldaarerp.com/public_html && git config --global user.email 'asdthehiro@gmail.com'");

// Initialize Git and set the remote URL
$ssh->exec("cd domains/aldaarerp.com/public_html && git init");
$ssh->exec("cd domains/aldaarerp.com/public_html && git remote set-url origin https://asdthehiro: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@github.com/asdthehiro/aldar_live.git");

// Check if the remote 'origin' is set, and add it if not
$remoteCheck = $ssh->exec("cd domains/aldaarerp.com/public_html && git remote -v");
if (strpos($remoteCheck, 'origin') === false) {
    $ssh->exec("cd domains/aldaarerp.com/public_html && git remote add origin https://asdthehiro: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@github.com/asdthehiro/aldar_live.git");
}

// Check the current branch (main or master)
$branchCheck = $ssh->exec("cd domains/aldaarerp.com/public_html && git branch --show-current");
$branch = trim($branchCheck) ?: 'main'; // Default to 'main' if no branch is detected

// Disable rebase strategy for pulling
$ssh->exec("cd domains/aldaarerp.com/public_html && git config pull.rebase false");

// Stash changes (including untracked files) before pulling

// Pull latest changes from the remote repository
$result = $ssh->exec("cd domains/aldaarerp.com/public_html && git pull origin main --allow-unrelated-histories");

// Apply stashed changes after pull
$ssh->exec("cd domains/aldaarerp.com/public_html && git stash pop");

echo "Pull Result:\n" . $result . "\n";
// Add any changes
$result = $ssh->exec("cd domains/aldaarerp.com/public_html && git add .");
echo "Add Result:\n" . $result . "\n";

// Commit changes with an IP address in the message
$result = $ssh->exec("cd domains/aldaarerp.com/public_html && git commit -m 'auto push - $ip'");
echo "Commit Result:\n" . $result . "\n";

// Push changes to the current branch
$result = $ssh->exec("cd domains/aldaarerp.com/public_html && git push origin $branch");
echo "Push Result:\n" . $result . "\n";
?>