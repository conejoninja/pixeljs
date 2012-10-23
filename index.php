<!DOCTYPE HTML>

<html>
  <head>
    <style>
      canvas {
        border: 1px solid #9C9898;
      }
      
        html, body {
            margin: 0px;
            padding: 0px;
            width:  100%;
            height: 100%;
            margin: 0px;
            background: #222;
        }

        .container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }
      
    </style>
    <script src="kinetic-v3.10.5.js"></script>
    <script src="img/icons.js"></script>
    <script>
      var w = window.innerWidth-2;
      var h = window.innerHeight-4;
      
        Kinetic.Rect.prototype.to2d = function(theta, rho) {
            var x=(this.attrs.x3d)*Math.cos((Math.PI/180)*theta)-(this.attrs.z3d)*Math.sin((Math.PI/180)*theta);
            var z1=(this.attrs.x3d)*Math.sin((Math.PI/180)*theta)+(this.attrs.z3d)*Math.cos((Math.PI/180)*theta);
            var y=(this.attrs.y3d)*Math.cos((Math.PI/180)*rho)-(z1)*Math.sin((Math.PI/180)*rho);
            var z=(this.attrs.y3d)*Math.sin((Math.PI/180)*rho)+(z1)*Math.cos((Math.PI/180)*rho);
            var d = 10000;
            var p =  {'x': 0, 'y' : 0, 'z' : 1};
            p.x = ((d*x)/(d+z));
            p.y = ((d*y)/(d+z));
            p.z = z;

            return p;
        }
        
        function loadIcon(icon) {
            var l = img_coord[icon].length;
            for(var n = 0; n < l; n++) {( function() {
                var randX = img_coord[icon][n][0];
                var randY = img_coord[icon][n][1];
                var randZ = ( Math.random() * 200 ) - 100;

                var box = new Kinetic.Rect({
                x3d: randX,
                y3d: randY,
                z3d: randZ,
                zIndex:1,
                offset: {
                    x: 5,
                    y: 5
                },
                width: 8,
                height: 8,
                fill: img_color[icon][n],
                stroke: img_color[icon][n],
                strokeWidth: 0
                });

                layer.add(box);
            }());
            }
        };
        
        
      window.onload = function() {
        var icon = Math.round(Math.random()*(img_coord.length-1));
        var stage = new Kinetic.Stage({
          container: "container",
          width: w,
          height: h
        });
        var layer = new Kinetic.Layer();
        var layerBck = new Kinetic.Layer();
        var xRandom = Math.random() * w * 0.8 + 0.1 * w;
        var yRandom = Math.random() * h * 0.8 + 0.1 * h;
        
        var background = new Kinetic.Rect({
              x: 0,
              y: 0,
              offset: {
                x: 0,
                y: 0
              },
              width: w,
              height: h,
              fill: "white",
              stroke: "white",
              strokeWidth: 0
            });

        layerBck.add(background);

        
        loadIcon(icon);
        
        stage.add(layerBck);
        stage.add(layer);

        stage.onFrame(function(frame) {
          
        });
        stage.start();
        
        stage.on("mousemove", function(evt){
            var mouse = stage.getUserPosition(evt);
            
            var boxes = layer.getChildren();
            zi = new Array();
            var bl = boxes.length;
            boxes[0].setZIndex(1);
            for(var n = 0; n < bl; n++) {
                var shape = boxes[n];
                var constk = 0.25;
                var coord = shape.to2d(constk*(mouse.x-xRandom), constk*(mouse.y-yRandom));
                shape.attrs.x = (w/2) + coord.x;
                shape.attrs.y = (h/2) + coord.y;
                shape.attrs.z = -coord.z;
                coord.z = 1 + (shape.attrs.z3d - coord.z) * 0.008
                if(coord.z<0.3) {
                    coord.z = 0.3;
                }
                if(coord.z>4) {
                    coord.z = 4;
                }
                shape.attrs.scale.x = coord.z;
                shape.attrs.scale.y = coord.z;
                for(var i = (n-1);i>0;i--) {
                    if(boxes[i].attrs.z>shape.attrs.z) {
                        shape.moveDown();
                        break;
                    }
                }
            }


            if(Math.abs(constk*(mouse.x-xRandom))<10 && Math.abs(constk*(mouse.y-yRandom))<10) {
                console.log("ESTOY CERCA");
            }


            layer.draw();
        });
        
      };

    </script>
  </head>
  <body onmousedown="return false;">
    <div id="container" class="container"></div>
  </body>
</html>
