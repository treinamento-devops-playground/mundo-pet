<?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                        $adminEmail = 'admin.@mail.com';
                        $adminSenha = password_hash('12345678', PASSWORD_DEFAULT);

                            // Verifica se o usuário foi encontrado e se a senha está correta
                            if ($email === $adminEmail && password_verify($password, $adminSenha)) {
                                // Redireciona para a página de administração
                                header("Location: admin.php");
                                exit();
                            } else {
                                echo "<p>Email ou senha estão errados.</p>";
                            }
                        }
                ?>