<?php
$action = (isset($_GET['action']))?htmlspecialchars($_GET['action']):'';

switch ($action){
    case "modif" :
        echo '<div id="corps"><a href="index.php">Retour</a></div>';
    break;
}
?>

<label for="modification"><strong>Modification des données :</strong></label> </br></br>
<table>
    <tr>
        <td><label for="type">Type</label></td>
        <td><SELECT name="type" size="1">
                <OPTION>Hardware
                <OPTION>Software
                <OPTION>Autres
            </SELECT>
        </td>
    </tr>
    <tr>
        <td><label for="Composant">Composant</label></td>
        <td><input type="text" name="Composant"/></td>
    </tr>
    <tr>
        <td><label for="SousComposant">SousComposant(Optionnel)</label></td>
        <td><input type="text" name="SousComposant"/></td>
    </tr>
    <tr>
        <td><label for="SousComposant2">SousComposant2(Optionnel)</label></td>
        <td><input type="text" name="SousComposant2"/></td>
    </tr>
    <tr>
        <td><label for="date">Date</label></td>
        <td><input type="datetime" name="date"/></td>
    </tr>
    <tr>
        <td><label for="description">Description</label></td>
        <td><textarea name="description" rows="5" cols="40"></textarea></td>
    </tr>
    <tr>
        <td><a href="Modification.php"><input type="submit" value="Valider" /></a></td>
    </tr>
</table>