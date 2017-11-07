<!DOCTYPE html>
<html lang="en">
<head>
    <link href="" rel='stylesheet' type='text/css' />
</head>
<body>


<form action = "<? echo base_url('users/deleteFriend');?>" method = "post">
    <?
foreach ($friends as $friend){
//    print_r ($friend);
    echo <<<HTML
        <li> {$friend['friendName']}
        <br>
         <input type="submit" name="name" value="Delete this friend"/>         
         <input type = "hidden" name="id" value="{$friend['friendID']}"/>
        </li>
HTML;
}?>
</form>
</body>
</html>