function qtiShapesEditClass(canvasIdentifier, backgroundImagePath, options){	if(!Raphael){		throw 'The raphael graphic library is required.';	}		var defaultOptions = {		stroke: 'black',		fill: '#E0DCDD',		opacity: .5,		backgroundImage: ''	}		this.options = $.extend(defaultOptions, options);		var $canvas = $('#'+canvasIdentifier);	if(!$canvas.length){		throw 'The canvas dom ellement not found.';	}	var $imgElt = $('<img src="'+backgroundImagePath+'"/>').insertAfter($canvas);	// $imgElt.attr('src', backgroundImagePath);		this.canvasIdentifier = canvasIdentifier;			this.shape = 'ellipse';//current shape:	this.currentId = 1; //the current working id		this._shapeObj = null;	this.path = [];//current path		this.startPoint = null;	this.endPoint = null;	this.shapes = [];		var self = this;			$imgElt.load(function(){		var width = $imgElt.width();		var height = $imgElt.height();		// CL('width', width);		// CL('height', height);		$imgElt.remove();				$canvas.css("background-image", 'url("'+backgroundImagePath+'")');		$canvas.css("background-repeat", "no-repeat");		$canvas.css('border', '3px solid red');		$canvas.width(width);		$canvas.height(height);				self.canvas = Raphael(canvasIdentifier, width, height);				// $canvas.css("background-image", 'url(./Blue hills.jpg)');				self.initEventHandlers();	});	}qtiShapesEditClass.prototype.setBackground = function(backgroundImagePath){		var self = this;		var $canvas = $('#'+this.canvasIdentifier);	if(!$canvas.length){		throw 'The canvas dom element not found.';	}		var $imgElt = $('<img src="'+backgroundImagePath+'"/>').insertAfter($canvas);		$imgElt.error(function(){		$(this).hide();//could display a message here	});		$imgElt.load(function(){		var width = $imgElt.width();		var height = $imgElt.height();		$imgElt.remove();				$canvas.css("background-image", 'url("'+backgroundImagePath+'")');		$canvas.width(width);		$canvas.height(height);				self.canvas.setSize(width, height);	});	}qtiShapesEditClass.prototype.setCurrentShape = function(shape){	this.shape = shape;}qtiShapesEditClass.prototype.setCurrentId = function(id){	if(id){		this.currentId = id;	}}qtiShapesEditClass.prototype.initEventHandlers = function(){	var self = this;	var $canvas = $('#'+this.canvasIdentifier);		//mouse down event: init the shape:	$canvas.mousedown(function(e){				if(self.shape){						var cursorPosition = {				x : e.pageX - this.offsetLeft,				y : e.pageY - this.offsetTop			};						if(self.shape == 'path'){				if(!self.focused){					self.focused = true;					self.removeShapeObj(self.currentId);					CD(self.path);					self.path = [];//reinit the path array					// self.path.push(cursorPosition);				}			}else{				self.focused = true;				self.startPoint = cursorPosition;				self.removeShapeObj(self.currentId);			}					}	});		//mouse move event: real time update the current shape (but "path")	$canvas.mousemove(function(e){		if(self.focused && self.startPoint){			if(self.shape){								var position = {					x : e.pageX - this.offsetLeft,					y : e.pageY - this.offsetTop				};								if(self.canvas[self.shape]){					// self.removeShapeObj();					self.setShapeObj(self.drawShape(self.startPoint, position), self.currentId);				}							}		}	});		//mouse up event: finishing the shap drawing (but "path")	$canvas.mouseup(function(e){		if(self.shape != 'path'){			self.focused = false;		}			});		//mouse click event: append a point to the "path" ("path" shape only)	$canvas.click(function(e){		if(self.focused && self.shape == 'path'){							var position = {				x : e.pageX - this.offsetLeft,				y : e.pageY - this.offsetTop			};						if(self.canvas[self.shape]){				// self.removeShapeObj();				self.setShapeObj(self.drawShape(null, position), self.currentId);//set in the temp shape object			}					}	});		//mouse double click event: closing the path ("path" shape only)	$canvas.dblclick(function(e){		e.preventDefault();		if(self.shape == 'path'){			//close the poly shape:			if(self.path){				if(self.canvas[self.shape]){					self.removeShapeObj();//delete the temp shape obj					self.setShapeObj(self.drawShape(null, self.path[0]), self.currentId);				}			}						self.focused = false;		}	});}qtiShapesEditClass.prototype.drawShape = function(startPoint, endPoint, shape){		var returnValue = null;	var raphaelObject = null;	var shapeObject = null;		if(!shape){		var shape = this.shape;	}		var shape = shape.toLowerCase();	//check if the drawing method exists:	if(this.canvas && this.canvas[shape]){		switch(shape){			case 'circle':{				var radius = Math.sqrt(Math.pow(endPoint.x-startPoint.x, 2)+Math.pow(endPoint.y-startPoint.y, 2))				raphaelObject = this.canvas.circle(startPoint.x, startPoint.y, radius);								shapeObject = {					type: 'circle',					c: startPoint,					r: radius				}				break;			}			case 'rect':{				var corner = {					x: Math.min(startPoint.x, endPoint.x),					y: Math.min(startPoint.y, endPoint.y)				};								var width = Math.max(startPoint.x, endPoint.x) - corner.x;				var height = Math.max(startPoint.y, endPoint.y) - corner.y;				raphaelObject = this.canvas.rect(corner.x, corner.y, width, height);								shapeObject = {					type: 'rect',					c: corner,					w: width,					h: height				};				break;			}			case 'ellipse':{				var horizontalRadius = Math.abs(endPoint.x - startPoint.x);				var verticalRadius = Math.abs(endPoint.y - startPoint.y);				raphaelObject = this.canvas.ellipse(startPoint.x, startPoint.y, horizontalRadius, verticalRadius);								shapeObject = {					type: 'ellipse',					c: startPoint,					h: horizontalRadius,					v: verticalRadius				};				break;			}			case 'path':{				var svgPath = '';				var thePath = []				//get the previous points:				if(this.path){					thePath = [];					this.path.push(endPoint); 										// var previousPoint = null;					for(var i=0; i<this.path.length; i++){						var currentPoint = this.path[i];						thePath.push(currentPoint);												if(i==0){							svgPath += 'M'+currentPoint.x+' '+currentPoint.y;						}else{							svgPath += 'L'+currentPoint.x+' '+currentPoint.y;						}					}				}else{					throw 'no path initiated';				}								shapeObject = {					type: 'path',					path: thePath				}								if(svgPath != ''){					raphaelObject = this.canvas.path(svgPath);				}								break;			}		}	}		if(raphaelObject){		raphaelObject.attr('fill', this.options.fill);		raphaelObject.attr('stroke', this.options.stroke);		raphaelObject.attr('fill-opacity', this.options.opacity);	}	// returnValue = raphaelObject;	returnValue = {		'raphaelObject': raphaelObject,		'shapeObject': shapeObject	}	return returnValue;}qtiShapesEditClass.prototype.removeShapeObj = function(id){	if(id){		if(this.shapes[id]){			if(this.shapes[id].raphaelObject){				if(this.shapes[id].raphaelObject.remove){					this.shapes[id].raphaelObject.remove();				}				delete this.shapes[id];			}		}	}else{		//remove the current temporary shape object:		if(this._shapeObj){			if(this._shapeObj.remove){				this._shapeObj.remove();			}			this._shapeObj = null;		}	}	}//replace the targetted shapeObject (in the shapes array or current temp) with the new oneqtiShapesEditClass.prototype.setShapeObj = function(shapeObj, id){		if(id){		this.removeShapeObj(id);		this.shapes[id] = shapeObj;		// CL('shape qtized:', this.exportShapeToQti(id));	}else{		this.removeShapeObj();		this._shapeObj = shapeObj;	}}//id must be uniqueqtiShapesEditClass.prototype.createShape = function(id, mode, options){		var shapeObject = null;		//import to the sharing object format:	switch(mode){		case 'draw':{			// var drawnShape = this.drawShape(options.startPoint, options.endPoint, options.shape);			var drawnShape = this.importShapeFromCanvas(options.startPoint, options.endPoint, options.shape);			shapeObject = {				initMode: mode,				type: options.shape,				raphaelObject: drawnShape.raphaelObject,				shapeObject: drawnShape.shapeObject			};						break;		}		case 'qti':{			var qtiShape = this.importShapeFromQti(options.data, options.shape);			shapeObject = {				initMode: mode,				type: options.shape,				qtiObject: qtiShape.qtiObject,				shapeObject: qtiShape.shapeObject			};						break;		}	}		if(shapeObject){		this.shapes[id] = shapeObject;		return true;	}		return false;}//export shape object to qti compatible strings:qtiShapesEditClass.prototype.exportShapeToQti = function(id, mode){	var returnValue = '';		//create qti coord string from itself or shapeObject	if(this.shapes[id]){		if(this.shapes[id].qtiObject){			returnValue = this.shapes[id].qtiObject;		}else if(this.shapes[id].shapeObject){			var shapeObject = this.shapes[id].shapeObject;			//processing required:			switch(shapeObject.type){				case 'circle':{					if(shapeObject.c && shapeObject.r){						returnValue = shapeObject.c.x+','+shapeObject.c.y+','+shapeObject.r;					} 					break;				}				case 'rect':{					if(shapeObject.c && shapeObject.w && shapeObject.h){						var rightX = shapeObject.c.x + shapeObject.w;						var bottomY = shapeObject.c.y + shapeObject.h;						returnValue = shapeObject.c.x+','+shapeObject.c.y+','+rightX+','+bottomY;					}					break;				}				case 'ellipse':{					if(shapeObject.c && shapeObject.h && shapeObject.v){						returnValue = shapeObject.c.x+','+shapeObject.c.y+','+shapeObject.h+','+shapeObject.v;					}					break;				}				case 'path':{					if(shapeObject.path){						for(var i=0; i<shapeObject.path.length; i++){							if(i>0){								returnValue += ',';							}							returnValue += shapeObject.path[i].x+','+shapeObject.path[i].y;						}					}					break;				}			}		}	}		return returnValue;}//draw on the canvas from the shapeObject:qtiShapesEditClass.prototype.exportShapeToCanvas = function(id, mode){	//draw from raphaelObject or shapeObject	var raphaelObject = null;	if(this.shapes[id]){		if(this.shapes[id].shapeObject){			var shapeObject = this.shapes[id].shapeObject;			switch(shapeObject){				case 'circle':{					if(shapeObject.c && shapeObject.r){						raphaelObject = this.canvas.circle(shapeObject.c.x, shapeObject.c.y, shapeObject.r);					}					break;				}				case 'rect':{					if(shapeObject.c && shapeObject.w && shapeObject.h){						raphaelObject = this.canvas.rect(shapeObject.c.x, shapeObject.c.y, shapeObject.w, shapeObject.h);					}					break;				}				case 'ellipse':{					if(shapeObject.c && shapeObject.h && shapeObject.v){						raphaelObject = this.canvas.ellipse(shapeObject.c.x, shapeObject.c.y, shapeObject.h, shapeObject.v);					}					break;				}				case 'path':{					if(shapeObject.path){						var svgPath = this.buildSVGpath(shapeObject.path);						raphaelObject = this.canvas.path(svgPath);					}					break;				}			}		}				if(raphaelObject){			this.shapes[id] = raphaelObject;		}	}}//create the shapeObject from the qti row data stringqtiShapesEditClass.prototype.importShapeFromQti = function(rowData, shape){		var returnValue = null;	var data = rowData.split(',');	var qtiObject = null;	var shapeObject = null;		switch(shape){		case 'circle':{			if(data.length == 3){				qtiObject = rowData;				//warning! radius could be in %				shapeObject = new Object();				shapeObject = {					type: 'circle',					c: {						x: data[0],						y: data[1]					},					r: data[2]				}			}else{				throw "wrong number of element found in circle row data";			}			break;		}		case 'rect':{			if(data.length == 4){				qtiObject = rowData;				//warning! radius could be in %				shapeObject = {					type: 'rect',					c: {						x: data[0],						y: data[1]					},					w: data[2],					h: data[3]				}			}else{				throw "wrong number of element found in rect row data";			}			break;		}		case 'ellipse':{			if(data.length == 4){				qtiObject = rowData;				//warning! radius could be in %				shapeObject = {					type: 'ellipse',					c: {						x: data[0],						y: data[1]					},					h: data[2],					v: data[3]				}			}else{				throw "wrong number of element found in ellipse row data";			}			break;		}		case 'path':{			if(data.length%2 == 0){				var path = [];								for(var i=0; i<data.length; i=i+1){					path.push({						x: data[i],						y: data[i+1]					});				}								//check if the final one is the same as the first:				if(path.length>=2){					if(path[0].x != path[path.length-1].x){						path.push(path[0]);					}				}								shapeObject = {					type: 'path',					path: path				};			}else{				throw "no even number of element found in poly/path row data";			}			break;		}	}	returnValue = {		'qtiObject': rowData,		'shapeObject': shapeObject	}	return returnValue; 		}//create shape object and draw on raphael canvas from graphical data:qtiShapesEditClass.prototype.importShapeFromCanvas = function(startPoint, endPoint, shape){	//draw:	return this.drawShape(startPoint, endPoint, shape);}qtiShapesEditClass.prototype.buildSVGpath = function(points){	var svgPath = '';		for(var i=0; i<points.length; i++){		var currentPoint = points[i];				if(i==0){			svgPath += 'M'+currentPoint.x+' '+currentPoint.y;		}else{			svgPath += 'L'+currentPoint.x+' '+currentPoint.y;		}	}		return svgPath;}