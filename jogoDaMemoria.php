<?php 
/*
Autor: Kaua Molina
Projeto: Jogo da Memoria
Data: 26/02/2026
Descricao:
- Desenvolvi um jogo da memoria em PHP usando emojis como cartas.
- Organizei o controle do jogo com sessoes para salvar o estado entre os cliques.
- Implementei embaralhamento das cartas, comparacao de pares e contador de tentativas.
- Adicionei botao para reiniciar a partida e recarregamento automatico quando o jogador erra.
- Estruturei a interface com HTML, CSS e apoio visual do Bootstrap.
*/
session_start();

// Reinicia toda a partida apagando os dados salvos na sessao.
if (isset($_POST['reiniciar'])) {
    session_unset();
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Cria o estado inicial do jogo na primeira vez que a pagina e aberta.
if (!isset($_SESSION['cartas'])) {
    $cartas=['😎', '😎', '🪐', '🪐', '🚀', '🚀', '🧬', '🧬','🍕','🍕','😍','😍'];
    shuffle($cartas);
    $_SESSION['cartas'] = $cartas;
    $_SESSION['cartasViradas'] = array_fill(0, count($cartas), false);
    $_SESSION['achadas']= [];
    $_SESSION['tentativas'] = 0;
    $_SESSION['primeira']= null;
} 
    
// Processa o clique do jogador em uma carta.
if (isset($_POST['carta'])) {
     $indice = (int)$_POST['carta'];

        // Guarda a primeira carta escolhida para comparar depois.
        if ($_SESSION['primeira'] === null) {
             $_SESSION['primeira'] = $indice;
        } else {
        // Quando escolhe a segunda carta, conta uma tentativa.
         $_SESSION['tentativas']++;

        $primeira = $_SESSION['primeira'];
        $segunda = $indice;

        // Se os valores forem iguais, o par e salvo como encontrado.
        if ($_SESSION['cartas'][$primeira] == $_SESSION['cartas'][$segunda]) {
            $_SESSION['achadas'][] = $primeira;
            $_SESSION['achadas'][] = $segunda;
            $_SESSION['primeira'] = null;
        } else {
            // Se errar, a segunda carta fica visivel por um instante antes de virar de novo.
            $_SESSION['segunda'] = $segunda;
            }
        }
}
 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Jogo da Memória</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <div class="mt-5 mx-auto p-2 text-center" >
            <h1>Jogo da Memória</h1>
            <p>Tentativas: <?php echo $_SESSION['tentativas']; ?></p>
            <form method="post" style="margin-top:20px;">
                <button class="btn btn-danger" type="submit" name="reiniciar" value="1">
                    Reiniciar Jogo
                </button>
            </form>
            <div class="tabuleiro">
                <?php 
                // Define quais cartas precisam aparecer abertas naquele momento.
                $mostrar = [];
                     if (isset($_SESSION['primeira'])) $mostrar[] = $_SESSION['primeira'];
                     if (isset($_SESSION['segunda'])) $mostrar[] = $_SESSION['segunda'];
                for ($i = 0; $i < count($_SESSION['cartas']); $i++): ?>
                    <form method="post" style="display:inline;">
                        <button class="carta" type="submit" name="carta" value="<?= $i ?>">
                          <?php
                            
                                // Mostra o emoji se a carta ja foi encontrada ou esta temporariamente aberta.
                                if (in_array($i, $_SESSION['achadas']) || in_array($i, $mostrar)) {
                                    echo $_SESSION['cartas'][$i];
                                } else {
                                     // Caso contrario, mantem a carta escondida.
                                     echo "?";
                                }
                            ?>
                        </button>
                    </form>
                <?php endfor; ?>
            </div>
            <script>
                <?php if(isset($_SESSION['segunda'])): ?>
                    setTimeout(function() {
                        // Recarrega a pagina para esconder novamente as cartas erradas.
                        window.location = window.location.href;
                    }, 1000);
                <?php 
                    // Depois do intervalo visual, limpa a segunda carta e libera uma nova jogada.
                    if (isset($_SESSION['segunda'])) {
                        $segundaTemp = $_SESSION['segunda'];
                        unset($_SESSION['segunda']);
                        $_SESSION['primeira'] = null;
                    }
                endif; ?>
            </script>
            <!-- Assinatura do projeto -->
            <footer style="margin-top:30px; font-size:0.8em; color:gray;">
                DevelopedByMolina &copy; 2026
            </footer>

        </div>
        
    </body>
</html>
