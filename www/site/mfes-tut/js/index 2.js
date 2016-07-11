/*var colors = [0xDE5006, 0x42447, 0xC0A468, 0xF38D58, 0x615173];*/

function Threejs () {

	this.shapes = [];

	// Init
	this.init = function(){
		this.scene = new THREE.Scene();
		this.camera();
		this.renderer();
/*		this.light();*/
		this.initShape();
		this.render();
	}

	// Camera
	this.camera = function(){
		this.camera = new THREE.OrthographicCamera( window.innerWidth / - 2, window.innerWidth / 2, window.innerHeight / 2, window.innerHeight / - 2, 1, 1000 );
		this.camera.position.x = 500;
		this.camera.position.y = 0;
		this.camera.position.z = 0;
		this.camera.updateProjectionMatrix();
		this.camera.lookAt(this.scene.position);
	}

	// Renderer
	this.renderer = function(){
		this.renderer = new THREE.WebGLRenderer({antialias: true});
		this.renderer.setSize( window.innerWidth, window.innerHeight );
		this.renderer.setClearColor( 0xa8aab1 , 1 );
		this.renderer.shadowMapEnabled = true;
		this.renderer.shadowMapType = THREE.PCFSoftShadowMap;
		var scope = this;
		scope.renderer.render( scope.scene, scope.camera );
		document.body.appendChild(this.renderer.domElement);
	}

	// Light
/*	this.light = function light() {
		var shadowlight = new THREE.DirectionalLight( 0xffffff, 2);
		shadowlight.position.set( 20, 10, 1 );
		shadowlight.castShadow = true;
		shadowlight.shadowDarkness = 0.01;
		this.scene.add(shadowlight);

		var light = new THREE.DirectionalLight( 0xffffff, 0.1 );
		light.position.set( 90, 100, 20 );
		this.scene.add(light);

		var backLight = new THREE.DirectionalLight( 0xffffff, 0.1 );
		backLight.position.set( 40, 100, 20 );
		this.scene.add(backLight);
	};*/
	// Init Shape
	this.initShape = function initShape() {
		this.group = new THREE.Group();
		this.scene.add(this.group);

		while(this.shapes.length < 80){
			var item = new Tetrahedron();
			this.shapes.push(item);
		}
		for (var i = 0; i < this.shapes.length; i++) {
			this.group.add(this.shapes[i].shape);
		};
		
		
		
	}

	// Render
	this.render = function render() {
		requestAnimationFrame(this.render.bind(this));
		for (var i = 0; i < this.shapes.length; i++) {
			this.shapes[i].animate();
		};
		this.renderer.render(this.scene, this.camera);
	};
}

var world = new Threejs();
world.init();



function Tetrahedron(){
	this.size = Math.random();
/*
	this.color = colors[Math.floor(Math.random()*colors.length)];*/

	this.geometry = new THREE.TetrahedronGeometry(this.size*40, 0);
	this.geometry.applyMatrix( new THREE.Matrix4().makeRotationAxis( new THREE.Vector3( 4, 0, -1 ).normalize(), Math.atan( Math.sqrt(2)) ) );
	this.material = new THREE.MeshLambertMaterial({color : this.color, shading: THREE.FlatShading,  wireframe: true});
	this.shape = new THREE.Mesh(this.geometry, this.material);
	this.shape.position.y = Math.floor((Math.random() * 3000) + 1)-1000;
	this.shape.position.z = Math.floor((Math.random() * 2000) + 1)-1000;
	this.shape.rotation.z = Math.floor((Math.random() * Math.PI) + 1);
	this.shape.rotation.y = Math.floor((Math.random() * Math.PI) + 5);
	this.shape.castShadow = false;
	this.shape.receiveShadow = false;

	this.animate = function(){
		
		if(this.shape.position.z > -1000){
			this.shape.position.z-= this.size*5;
			this.shape.rotation.z+= Math.PI/180*this.size*2;
			this.shape.rotation.y+= Math.PI/180*this.size*2;
		}else{
			this.shape.position.z = 1000;
		}
	}
}