module.exports = {
    Game: Game,
    Player: Player,
    DiceRoller: DiceRoller,
    Checker: Checker,
    Point: Point
};
function Player(id, fullname) {
    this.id = id;
    this.fullname = fullname;
    this.disconnectTime = 60;
}
function Checker(player) {
    this.player = player;
}
function Point(position) {
    this.addChecker = function (checker) {
        this.checkers.push(checker);
    }
    this.firstChecker = function () {
        return this.checkers[0];
    }
    this.removeChecker = function (checker) {
        for (var i = 0; i < this.checkers.length; i++) {
            if (this.checkers[i] == checker) {
                this.checkers.splice(i, 1);
                return true;
            }
        }
        return false;
    }
    this.popChecker = function () {
        var checker = this.firstChecker();
        this.removeChecker(checker);
        return checker;
    }
    this.checkersCount = function () {
        return this.checkers.length;
    }
    this.playerCheckersCount = function (player) {
        var count = 0;
        for (var i = 0, len = this.checkersCount(); i < len; i++) {
            if (parseInt(this.checkers[i].player.id) === parseInt(player.id)) {
                count++;
            }
        }
        return count;
    }
    this.otherPlayerCheckersCount = function (player) {
        return this.checkersCount() - this.playerCheckersCount(player);
    }
    this.position = position;
    this.checkers = [];
}
function DiceRoller() {
    this.generateNumber = function () {
        return Math.floor((Math.random() * 6) + 1);
    }
    this.roll = function () {
        this.values = [];
        this.firstValue = this.generateNumber();
        this.secondValue = this.generateNumber();
        this.addValue(this.firstValue);
        this.addValue(this.secondValue);
        if (this.gotPair()) {
            this.addValue(this.firstValue);
            this.addValue(this.firstValue);
        }
    }
    this.rollUntilNotPair = function () {
        this.roll();
        if (this.gotPair()) {
            this.rollUntilNotPair();
        }
    }
    this.gotPair = function () {
        return (this.firstValue == this.secondValue);
    }
    this.hasValue = function (value) {
        return (this.indexOfValue(value) !== -1);
    }
    this.useValue = function (value) {
        if (this.hasValue(value)) {
            this.values.splice(this.indexOfValue(value), 1);
            return true;
        }
        return false;
    }
    this.addValue = function (value) {
        this.values.push(value);
    }
    this.valuesCount = function () {
        return this.values.length;
    }
    this.indexOfValue = function (value) {
        for (i = 0; i < this.values.length; i++) {
            if (this.values[i] == value) {
                return i;
            }
        }
        return -1;
    }
    this.values = [];
    this.firstValue = null;
    this.secondValue = null;
}
function Game() {
    this.getData = function () {
        return {
            id: this.id,
            amount: this.amount,
            player1: this.player1,
            player2: this.player2 ? this.player2 : null,
            type_title: this.type_title,
            status_id: this.status_id
        };
    }
    this.setPlayer = function (id, player) {
        if (id == 1) {
            this.player1 = player;
        }
        else if (id == 2) {
            this.player2 = player;
        }
    }
    this.start = function () {
        this.putCheckers(this.player1, 24, 2);
        this.putCheckers(this.player1, 13, 5);
        this.putCheckers(this.player1, 8, 3);
        this.putCheckers(this.player1, 6, 5);
        this.putCheckers(this.player2, 1, 2);
        this.putCheckers(this.player2, 12, 5);
        this.putCheckers(this.player2, 17, 3);
        this.putCheckers(this.player2, 19, 5);
        this.diceRoller.rollUntilNotPair();
        if (this.diceRoller.firstValue > this.diceRoller.secondValue) {
            this.setCurrentPlayer(this.player1);
        }
        else {
            this.setCurrentPlayer(this.player2);
        }
        this.markStarted();
    }
    this.availableMoves = function () {
        var moves = [];
        if (this.diceRoller.valuesCount()) {
            if (this.currentPlayer.id == this.player1.id) {
                var graveyard = this.player1Graveyard;
                if (graveyard.checkersCount()) {
                    for (var i = 24; i >= 19; i--) {
                        var pointY = this.getPoint(i);
                        if (this.canMove(graveyard.position, pointY.position)) {
                            moves.push({from: graveyard.position, to: pointY.position, dist: this.getDistanceBetweenPoints(graveyard, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                        }
                    }
                }
                else if (this.hasCheckersOutsideHomeArea(this.player1)) {
                    for (var i = 24; i > 1; i--) {
                        var pointX = this.getPoint(i);
                        for (var j = (i - 1), len = (i > 7 ? i - 6 : 1); j >= len; j--) {
                            var pointY = this.getPoint(j);
                            if (this.canMove(pointX.position, pointY.position)) {
                                moves.push({from: pointX.position, to: pointY.position, dist: this.getDistanceBetweenPoints(pointX, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                            }
                        }
                    }
                }
                else {
                    var homeyard = this.currentPlayerHome();
                    for (var i = 1; i <= 6; i++) {
                        var pointX = this.getPoint(i);
                        if (this.canMove(pointX.position, homeyard.position)) {
                            moves.push({from: pointX.position, to: homeyard.position, dist: this.getDistanceBetweenPoints(pointX, homeyard), count: this.getCheckersCountOnPoint(homeyard.position)});
                        }
                    }
                    for (var i = 6; i > 1; i--) {
                        var pointX = this.getPoint(i);
                        for (var j = (i - 1); j >= 1; j--) {
                            var pointY = this.getPoint(j);
                            if (this.canMove(pointX.position, pointY.position)) {
                                moves.push({from: pointX.position, to: pointY.position, dist: this.getDistanceBetweenPoints(pointX, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                            }
                        }
                    }
                }
            }
            else if (this.currentPlayer.id == this.player2.id) {
                var graveyard = this.player2Graveyard;
                if (graveyard.checkersCount()) {
                    for (var i = 1; i <= 6; i++) {
                        var pointY = this.getPoint(i);
                        if (this.canMove(graveyard.position, pointY.position)) {
                            moves.push({from: graveyard.position, to: pointY.position, dist: this.getDistanceBetweenPoints(graveyard, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                        }
                    }
                }
                else if (this.hasCheckersOutsideHomeArea(this.player2)) {
                    for (var i = 1; i <= 23; i++) {
                        var pointX = this.getPoint(i);
                        for (var j = (i + 1), len = (i <= 17 ? i + 6 : 24); j <= len; j++) {
                            var pointY = this.getPoint(j);
                            if (this.canMove(pointX.position, pointY.position)) {
                                moves.push({from: pointX.position, to: pointY.position, dist: this.getDistanceBetweenPoints(pointX, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                            }
                        }
                    }
                }
                else {
                    var homeyard = this.currentPlayerHome();
                    for (var i = 24; i >= 19; i--) {
                        var pointX = this.getPoint(i);
                        if (this.canMove(pointX.position, homeyard.position)) {
                            moves.push({from: pointX.position, to: homeyard.position, dist: this.getDistanceBetweenPoints(pointX, homeyard), count: this.getCheckersCountOnPoint(homeyard.position)});
                        }
                    }
                    for (var i = 19; i < 24; i++) {
                        var pointX = this.getPoint(i);
                        for (var j = (i + 1); j <= 24; j++) {
                            var pointY = this.getPoint(j);
                            if (this.canMove(pointX.position, pointY.position)) {
                                moves.push({from: pointX.position, to: pointY.position, dist: this.getDistanceBetweenPoints(pointX, pointY), count: this.getCheckersCountOnPoint(pointY.position)});
                            }
                        }
                    }
                }
            }
        }
        return moves;
    }
    this.canMove = function (source, target) {
        
        var sourcePoint = this.positionToPoint(parseInt(source));
        var targetPoint = this.positionToPoint(parseInt(target));
        var home = this.currentPlayerHome();
        var graveyard = this.currentPlayerGraveyard();

        if (sourcePoint.playerCheckersCount(this.currentPlayer) === 0) {
            return false;
        }
        
        if (!this.isCorrectDirection(sourcePoint, targetPoint, this.currentPlayer)) {
            return false;
        }
        
        if (graveyard.checkersCount() > 0 && parseInt(sourcePoint.position) !== parseInt(graveyard.position)) {
            return false;
        }
        
        if (targetPoint.otherPlayerCheckersCount(this.currentPlayer) >= 2) {
            return false;
        }
        
        if (parseInt(targetPoint.position) === parseInt(home.position) && this.hasCheckersOutsideHomeArea(this.currentPlayer)) {
            return false;
        }
        
        var distance = this.getDistanceBetweenPoints(sourcePoint, targetPoint);
        
        if (!this.hasCheckersOutsideHomeArea(this.currentPlayer)) {

            if (this.diceRoller.hasValue(distance)) {
                return true;
            }

            if (parseInt(this.currentPlayer.id) === parseInt(this.player1.id)) {

                for (var i = 1; i < sourcePoint.position; i++) {
                    if (this.diceRoller.hasValue(i) && targetPoint.position === (parseInt(sourcePoint.position) - i)) {
                        return true;
                    }
                }

                var o = null;
                for (var j = 0, max = this.diceRoller.values.length; j < max; j++) {
                    if (this.diceRoller.values[j] > distance) {
                        for (var x = 1; x <= (6 - sourcePoint.position); x++) {
                            if ((o == null || o == true) && this.getPoint(sourcePoint.position + x).playerCheckersCount(this.player1) == 0 && targetPoint == this.player1Home) {
                                o = true;
                            }
                            else {
                                o = false;
                            }
                        }
                    }
                }
                return o == null ? false : o;
            }
            else if (this.currentPlayer == this.player2) {
                for (var i = 24; i > sourcePoint.position; i--) {
                    if (targetPoint.position == i && this.diceRoller.hasValue(i - sourcePoint.position)) {
                        return true;
                    }
                }

                var o = null;
                for (var j = 0, max = this.diceRoller.values.length; j < max; j++) {
                    if (this.diceRoller.values[j] > distance) {
                        for (var x = 1; x <= (sourcePoint.position - 19); x++) {

                            var point = this.positionToPoint(sourcePoint.position - x);
                            if (
                                    (o == null || o == true) &&
                                    point.playerCheckersCount(this.player2) == 0 &&
                                    targetPoint == this.player2Home
                                    ) {
                                o = true;
                            }
                            else {
                                o = false;
                            }
                        }
                    }
                }
                return o == null ? false : o;
            }
            return false;
        }
        
        return this.diceRoller.hasValue(distance);
    }
    this.moveChecker = function (source, target) {

        if (typeof source !== 'number' || typeof target !== 'number') {
            console.log('error (moveChecker): 1');
            console.log('source or target is not number');
            return false;
        }
        if (this.diceRoller.valuesCount() == 0) {
            console.log('error (moveChecker): 2');
            console.log('No moves left');
            return false;
        }

        var sourcePoint = this.positionToPoint(source);
        var targetPoint = this.positionToPoint(target);

        targetPoint.addChecker(sourcePoint.popChecker());

        var removedChecker = false;
        var checker = targetPoint.firstChecker();
        if (checker.player !== this.currentPlayer) {
            targetPoint.removeChecker(checker);
            this.oppositePlayerGraveyard().addChecker(checker);
            removedChecker = true;
        }

        var distance = this.getDistanceBetweenPoints(sourcePoint, targetPoint);
        var usedValue = distance;

        if (this.diceRoller.hasValue(distance)) {
            this.diceRoller.useValue(distance);
        }
        else {
            for (var i = 0; i < this.diceRoller.values.length; i++) {
                if (this.diceRoller.values[i] > distance) {
                    this.diceRoller.useValue(this.diceRoller.values[i]);
                    usedValue = this.diceRoller.values[i];
                    break;
                }
            }
        }

        this.history.push({
            sourcePoint: sourcePoint,
            targetPoint: targetPoint,
            player: this.currentPlayer,
            removedChecker: removedChecker,
            usedValue: usedValue
        });

        return distance;
    }
    this.finishTurn = function () {
        if (this.player1Home.checkersCount() == 15) {
            this.isEnd = true;
            this.winner = this.player1;
            this.loser = this.player2;
            return true;
        }
        else if (this.player2Home.checkersCount() == 15) {
            this.isEnd = true;
            this.winner = this.player2;
            this.loser = this.player1;
            return true;
        }

        this.switchPlayer();
        this.diceRoller.roll();
        return false;
    }
    this.undo = function () {
        var lastMovement = this.history[this.history.length - 1];
        if (lastMovement && lastMovement.player == this.currentPlayer) {

            this.history.splice(-1, 1);

            var usedValue = lastMovement.usedValue;
            var sourcePoint = lastMovement.sourcePoint;
            var targetPoint = lastMovement.targetPoint;
            var removedChecker = lastMovement.removedChecker;

            var checker = targetPoint.popChecker();
            sourcePoint.addChecker(checker);

            if (removedChecker) {
                var oppositeGraveyard = this.oppositePlayerGraveyard();
                var oppositeChecker = oppositeGraveyard.firstChecker();
                oppositeGraveyard.removeChecker(oppositeChecker);
                targetPoint.addChecker(oppositeChecker);
            }

            this.diceRoller.addValue(usedValue);
        }
    }
    this.getDistanceBetweenPoints = function (source, target) {
        if (source.position > 24) {
            if (this.currentPlayer == this.player1) {
                return Math.abs(25 - target.position);
            }
            else {
                return target.position;
            }
        }
        else {
            if (target.position > 24) {
                if (this.currentPlayer == this.player1) {
                    return source.position;
                }
                else {
                    return Math.abs(25 - source.position);
                }
            }
            else {
                return Math.abs(source.position - target.position);
            }
        }
    }
    this.currentPlayerGraveyard = function () {
        if (this.currentPlayer == this.player1) {
            return this.player1Graveyard;
        }
        else {
            return this.player2Graveyard;
        }
    }
    this.currentPlayerHome = function () {
        if (this.currentPlayer == this.player1) {
            return this.player1Home;
        }
        else {
            return this.player2Home;
        }
    }
    this.getPoint = function (id) {
        return this.points[id - 1];
    }
    this.switchPlayer = function () {
        if (this.currentPlayer == this.player1) {
            this.currentPlayer = this.player2;
        }
        else {
            this.currentPlayer = this.player1;
        }
    }
    this.markStarted = function () {
        this.isStarted = true;
    }
    this.setCurrentPlayer = function (player) {
        this.currentPlayer = player;
    }
    this.getCurrentPlayer = function () {
        return this.currentPlayer;
    }
    this.putCheckers = function (player, position, count) {
        var checker;
        var point = this.positionToPoint(position);
        for (i = 0; i < count; i++) {
            checker = new Checker(player);
            point.addChecker(checker);
        }
    }
    this.getCheckersCountOnPoint = function (position) {
        var point = this.positionToPoint(position);
        return point.checkersCount();
    }
    this.createPoints = function () {
        for (var i = 1; i <= 24; i++) {
            this.points.push(new Point(i));
        }
    }
    this.isCorrectDirection = function (source, target, player) {
        var source_position = parseInt(source.position);
        var target_position = parseInt(target.position);
        var currentplayerid = parseInt(player.id);
        var player1id = parseInt(this.player1.id);
        if (currentplayerid === player1id) {
            if (source_position === 25) { //from home
                return false;
            }
            else if (source_position === 26) { //from grave
                return target_position >= 19 && target_position <= 24;
            }
            else if (target_position === 25) { //to home
                return source_position >= 1 && source_position <= 6;
            }
            else {
                return source_position > target_position;
            }
        }
        else {
            if (source_position === 27) { // from home
                return false;
            }
            else if (source_position === 28) { // from grave
                return target_position >= 1 && target_position <= 6;
            }
            else if (target_position === 27) { //to home
                return source_position >= 19 && source_position <= 24;
            }
            return target_position > source_position;
        }
    }
    this.hasCheckersOutsideHomeArea = function (player) {
        var from = 1;
        var to = 18;
        if (parseInt(player.id) === parseInt(this.player1.id)) {
            if (this.player1Graveyard.checkersCount() > 0) {
                return true;
            }
            from = 7;
            to = 24;
        }
        else {
            if (this.player2Graveyard.checkersCount() > 0) {
                return true;
            }
        }
        for (var i = from; i <= to; i++) {
            if (this.getPoint(i).playerCheckersCount(player) > 0) {
                return true;
            }
        }
        return false;
    }
    this.oppositePlayerGraveyard = function () {
        if (this.currentPlayer == this.player1) {
            return this.player2Graveyard;
        }
        else {
            return this.player1Graveyard;
        }
    }
    this.positionToPoint = function (position) {
        position = parseInt(position);
        var point = null;
        if (position < 25) {
            point = this.getPoint(position);
        }
        else if (position === 25) {
            point = this.player1Home;
        }
        else if (position === 26) {
            point = this.player1Graveyard;
        }
        else if (position === 27) {
            point = this.player2Home;
        }
        else if (position === 28) {
            point = this.player2Graveyard;
        }
        return point;
    }
    this.lig_id = null;
    this.id = null;
    this.type_id = null;
    this.type_title = null;
    this.amount = null;
    this.total_amount = null;
    this.status_id = null;
    this.board_id = null;
    this.dice_id = null;
    this.player1 = null;
    this.player2 = null;
    this.isStarted = false;
    this.isEnd = false;
    this.currentPlayer = null;
    this.winner = -1;
    this.loser = -1;
    this.diceRoller = new DiceRoller();
    this.points = [];
    this.history = [];
    this.canMoveChecker = false;
    this.createPoints();
    this.player1Home = new Point(25);
    this.player1Graveyard = new Point(26);
    this.player2Home = new Point(27);
    this.player2Graveyard = new Point(28);
}