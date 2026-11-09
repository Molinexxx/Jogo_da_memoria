# Jogo da Memória

Jogo de navegador em que o objetivo é encontrar seis pares de emojis em um tabuleiro de 12 cartas embaralhadas.

## Como funciona

1. Vire duas cartas. A segunda escolha conta como uma tentativa.
2. Se os emojis coincidirem, o par continua visível. Caso contrário, as cartas aparecem brevemente e voltam a ficar ocultas.
3. Use **Reiniciar Jogo** para começar uma nova partida.

O estado do tabuleiro e o número de tentativas ficam na sessão PHP do navegador.

## Tecnologias e arquivos

- [jogoDaMemoria.php](jogoDaMemoria.php) concentra as regras, os formulários e a interface HTML. Um pequeno trecho de JavaScript aciona a atualização após uma combinação incorreta.
- [css/style.css](css/style.css) define o estilo do tabuleiro. A página também carrega a folha de estilos do Bootstrap por CDN.

## Como executar

Na raiz do repositório, com o PHP instalado:

```bash
php -S localhost:8000
```

Abra [http://localhost:8000/jogoDaMemoria.php](http://localhost:8000/jogoDaMemoria.php).

## Aprendizados e status

Projeto de estudo sobre sessões, processamento de formulários e regras de jogo no servidor. Cada sessão mantém sua própria partida.
