let origBoard;
const HUMAN_PLAYER = '0';
const AI_PLAYER = 'x';
e = 0;
m = 0;
h = 0;

const winCombos = [
  [0, 1, 2],
  [3, 4, 5],
  [6, 7, 8],

  [0, 3, 6],
  [1, 4, 7],
  [2, 5, 8],

  [0, 4, 8],
  [2, 4, 6]
];

function UpdateRecord(id)
  {
      jQuery.ajax({
       type: "POST",
       data: 'idq='+id,
       url: "server.php",
       cache: false 
     });
 }

 function es(){
    e = 1;
    m = 0;
    h = 0;
    onStartGame();
 }

 function ms(){
    e = 0;
    m = 1;
    h = 0;
    onStartGame();
 }

 function hs(){
    e = 0;
    m = 0;
    h = 1;
    onStartGame();
 }

const cells = document.getElementsByClassName('cell');

function onStartGame() {
  document.querySelector('.end-game').style.display = 'none';
  origBoard = Array.from(Array(9).keys());
  for (let i = 0; i < cells.length; i++) {
    cells[i].innerText = '';
    cells[i].style.removeProperty('background-color');
    cells[i].addEventListener('click', onTurnClick, false);
  }
};

function onTurnClick(e) {
  const { id: squareId } = e.target;
  if (typeof origBoard[squareId] === 'number') {
    onTurn(squareId, HUMAN_PLAYER);
    if (!onCheckGameTie()) {
      onTurn(botPicksSpot(), AI_PLAYER)
    }
  }
}

function onTurn(squareId, player) {
  origBoard[squareId] = player;
  document.getElementById(squareId).innerText = player;
  let isGameWon = onCheckWin(origBoard, player);
  if (isGameWon) {
    onGameOver(isGameWon);
  }
}

function onCheckWin(board, player) {
  let plays = board.reduce((a, e, i) => {
    return (e === player) ? a.concat(i) : a;
  }, []);
  let gameWon = false;
  for (let [index, win] of winCombos.entries()) {
    if (win.every(elem => plays.indexOf(elem) > -1)) {
      gameWon = {
        index: index,
        player: player
      };
      break;
    }
  }
  return gameWon;
}

function onGameOver({ index, player }) {
  for (let i of winCombos[index]) {
    const color = (player === HUMAN_PLAYER) ? '#2196f3' : '#f44336';
    document.getElementById(i).style.backgroundColor = color;
  }
  for (let i = 0; i < cells.length; i++) {
    cells[i].removeEventListener('click', onTurnClick, false)
  } 
  const result = (player === HUMAN_PLAYER) ? 'You Win' : 'You Lose';
  onDeclareWinner(result);
}

function onDeclareWinner(who) {
  if(who=='A Draw'){
    UpdateRecord("0");
  }else if(who=='You Lose'){
    UpdateRecord("-1");
  }else if(who=='You Win'){
    UpdateRecord("1");
  }
  document.querySelector('.end-game').style.display = 'block';
  document.querySelector('.end-game .text').innerText = `Result: ${who}`;
}

function onCheckGameTie() {
  if (emptySquares().length === 0) {
    for (let i = 0; i < cells.length; i++) {
      cells[i].style.backgroundColor = '#8bc34a';
      cells[i].removeEventListener('click', onTurnClick, false)
    }
    onDeclareWinner('A Draw');
    return true;
  } else {
    return false;
  }
}

function emptySquares() {
  return origBoard.filter(item => typeof item === 'number');
}

function botPicksSpot() {
  if(e==1){
    return emptySquares()[0];
  }
  if(h==1){
    return minimax(origBoard, AI_PLAYER).index;
  }
  else if(m==1){
    var min=0; 
    var max=1;  
    var random = Math.floor(Math.random() * (+max - +min)) + +min;
    if(random==0){
        return minimax(origBoard, AI_PLAYER).index;
    }
    else{
        return emptySquares()[0];
    }
  }
}

function minimax(newBoard, player) {
  let availableSpots = emptySquares();

  if (onCheckWin(newBoard, HUMAN_PLAYER)) {
    return { score: -10 }
  } else if (onCheckWin(newBoard, AI_PLAYER)) {
    return { score: 10 }
  } else if (availableSpots.length === 0) {
    return { score: 0 }
  }

  let moves = [];

  for (let i=0; i<availableSpots.length; i++) {
    let move = {};
    move.index = newBoard[availableSpots[i]];
    newBoard[availableSpots[i]] = player;

    if (player === AI_PLAYER) {
      let result = minimax(newBoard, HUMAN_PLAYER);
      move.score = result.score;
    } else {
      let result = minimax(newBoard, AI_PLAYER);
      move.score = result.score;
    }

    newBoard[availableSpots[i]] = move.index;
    moves.push(move);
  } 

  let bestMove;

  if (player === AI_PLAYER) {
    let bestScore = -10000;
    for (let i=0; i<moves.length; i++) {
      if (moves[i].score > bestScore) {
        bestScore = moves[i].score;
        bestMove = i;
      }
    }
  } 
  else {
    let bestScore = 10000;
    for (let i=0; i<moves.length; i++) {
      if (moves[i].score < bestScore) {
        bestScore = moves[i].score;
        bestMove = i;
      }
    }
  }

  return moves[bestMove];
}


