<?php
echo "student1: " . password_hash("student1", PASSWORD_BCRYPT) . "<br>";
echo "student2: " . password_hash("student2", PASSWORD_BCRYPT) . "<br>";
echo "osaspass: " . password_hash("osaspass", PASSWORD_BCRYPT) . "<br>";
echo "admin2: " . password_hash("admin2", PASSWORD_BCRYPT) . "<br>";
echo "admin1 → " . password_hash("admin1", PASSWORD_BCRYPT) . "<br>";
?>
