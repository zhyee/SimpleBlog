    var digit = [
					[
						[0,0,1,1,1,0,0],
						[0,1,1,0,1,1,0],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,0,1,1,0],
						[0,0,1,1,1,0,0]
					],//0
					[
						[0,0,0,1,1,0,0],
						[0,1,1,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[1,1,1,1,1,1,1]
					],//1
					[
						[0,1,1,1,1,1,0],
						[1,1,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,0,0],
						[0,0,1,1,0,0,0],
						[0,1,1,0,0,0,0],
						[1,1,0,0,0,0,0],
						[1,1,0,0,0,1,1],
						[1,1,1,1,1,1,1]
					],//2
					[
						[1,1,1,1,1,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,0,0],
						[0,0,1,1,1,0,0],
						[0,0,0,0,1,1,0],
						[0,0,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,1,1,0]
					],//3
					[
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,1,0],
						[0,0,1,1,1,1,0],
						[0,1,1,0,1,1,0],
						[1,1,0,0,1,1,0],
						[1,1,1,1,1,1,1],
						[0,0,0,0,1,1,0],
						[0,0,0,0,1,1,0],
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,1,1]
					],//4
					[
						[1,1,1,1,1,1,1],
						[1,1,0,0,0,0,0],
						[1,1,0,0,0,0,0],
						[1,1,1,1,1,1,0],
						[0,0,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,1,1,0]
					],//5
					[
						[0,0,0,0,1,1,0],
						[0,0,1,1,0,0,0],
						[0,1,1,0,0,0,0],
						[1,1,0,0,0,0,0],
						[1,1,0,1,1,1,0],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,1,1,0]
					],//6
					[
						[1,1,1,1,1,1,1],
						[1,1,0,0,0,1,1],
						[0,0,0,0,1,1,0],
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,0,0],
						[0,0,0,1,1,0,0],
						[0,0,1,1,0,0,0],
						[0,0,1,1,0,0,0],
						[0,0,1,1,0,0,0],
						[0,0,1,1,0,0,0]
					],//7
					[
						[0,1,1,1,1,1,0],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,1,1,0],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,1,1,0]
					],//8
					[
						[0,1,1,1,1,1,0],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[1,1,0,0,0,1,1],
						[0,1,1,1,0,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,0,1,1],
						[0,0,0,0,1,1,0],
						[0,0,0,1,1,0,0],
						[0,1,1,0,0,0,0]
					],//9
					[
						[0,0,0,0],
						[0,0,0,0],
						[0,1,1,0],
						[0,1,1,0],
						[0,0,0,0],
						[0,0,0,0],
						[0,1,1,0],
						[0,1,1,0],
						[0,0,0,0],
						[0,0,0,0]
					]//:
				];

    (function (){
        function Ball(x, y, r, vx, vy, g){
            this.x = x;
            this.y = y;
            this.r = r;
            this.vx = vx;
            this.vy = vy;
            this.g = g;
            var colors =
				[
					'#33B5E5',
					'#0099CC',
					'#AA66CC',
					'#9933CC',
					'#99CC00',
					'#669900',
					'#FFBB33',
					'#FF8800',
					'#FF4444',
					'#CC0000'
				];
            this.color = colors[Math.floor(Math.random() * colors.length)];
        }

        Ball.prototype = {
            move : function (context) {
                this.x += this.vx;
                this.y += this.vy;
                this.vy += this.g;
                if(this.y >= context.canvas.height - this.r){
                    this.y = context.canvas.height - this.r;
                    this.vy = -1 * this.vy * 0.7;
                }
            },
            draw : function (context) {
                var oldStyle = context.fillStyle;
                context.fillStyle = this.color;
                context.beginPath();
                context.arc(this.x, this.y, this.r, 0, 2 * Math.PI);
                context.closePath();
                context.fill();
                context.fillStyle = oldStyle;
            }
        };

        window.Ball = Ball;
    })();

    var balls = [];
    var currentTime = getTime();
    var canvas = document.getElementById('canvas');

    canvas.width = canvas.parentNode.clientWidth - 30;
    canvas.height = canvas.width * 0.45;
    var RADIUS = Math.round(canvas.width * 0.8 / 114) - 1;
    var MARGIN_LEFT = 2 * (RADIUS + 1);
    var MARGIN_TOP = 2 * (RADIUS + 1);
    var ctx = canvas.getContext('2d');
    ctx.fillStyle = 'rgb(0,102,153)';


    drawTime();
    setInterval(drawTime, 50);

    function drawTime(){
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

        var nextTime = getTime();
        var startX = Math.round((canvas.width - (RADIUS + 1) * 114) / 2);
        var startY = MARGIN_TOP;

        currentTimeArr = currentTime.split('');
        nextTimeArr = nextTime.split('');

        for(var i in nextTime){
            if(i > 0 && i % 2 == 0){
                drawDigit(10, startX, startY);
                startX += 4 * 2 * (RADIUS+1) + MARGIN_LEFT;
            }
            if(nextTimeArr[i] != currentTimeArr[i]){
                addBalls(nextTime[i], startX, startY);
            }
            drawDigit(nextTime[i], startX, startY);
            startX += 7 * 2 * (RADIUS+1) + MARGIN_LEFT;

        }
        moveBalls();
        if(currentTime != nextTime){
            currentTime = nextTime;
        }
    }

    function drawDigit(num, startX, startY){
        num = parseInt(num);
        if(num < 0 || num > 10){
            return;
        }

        startX = startX || 0;
        startY = startY || 0;

        for(var i = 0; i < digit[num].length; i++){
            for(var j = 0; j < digit[num][i].length; j++){
                if(digit[num][i][j]){
                    ctx.beginPath();
                    ctx.arc(startX + (j*2+1) * (RADIUS + 1), startY + (i*2+1) * (RADIUS + 1), RADIUS, 0, 2 * Math.PI);
                    ctx.closePath();
                    ctx.fill();
                }
            }
        }

    }

    function addBalls(num, startX, startY){
        for(var i = 0; i < digit[num].length; i++){
            for(var j = 0; j < digit[num][i].length; j++){
                if(digit[num][i][j]){
                    balls.push(new Ball(
                            startX + (j*2+1) * (RADIUS + 1),
                            startY + (i*2+1) * (RADIUS + 1),
                            RADIUS,
                            Math.floor(2 + Math.random() * 4) * Math.pow(-1, Math.floor(Math.random() * 2)),
                            -8,
                            1.5 + Math.random()
                        )
                    );
                }
            }
        }
    }

    function moveBalls(){
        for(var i in balls){
            if(balls[i].x > ctx.canvas.width + RADIUS || balls[i].x < -1 * RADIUS){
                balls.splice(i, 1);
                continue;
            }
            balls[i].draw(ctx);
            balls[i].move(ctx);
        }
    }

    function zeroFill(num, length){
        length = length || 2;
        num = num.toString();
        if(num.length < length){
            var freeLength = length - num.length;
            for(var i=0; i < freeLength; i++){
                num = '0' + num;
            }
        }
        return num;
    }

    function getTime(){
        var date = new Date();
        var time = '';
        time += zeroFill(date.getHours());
        time += zeroFill(date.getMinutes());
        time += zeroFill(date.getSeconds());
        return time;
    }