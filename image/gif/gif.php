<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mouse Click Animation</title>
    <style>
        body { margin: 0; overflow: hidden; background-color: #f0f0f0; }
        canvas { display: block; }
    </style>
</head>
<body>
    <!-- Include Three.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/examples/js/controls/OrbitControls.js"></script>

    <script>
        // Scene setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        // Create dynamic gradient background
        const colors = [new THREE.Color(0xff7f7f), new THREE.Color(0x7fff7f), new THREE.Color(0x7f7fff)];
        let colorIndex = 0;
        function animateBackground() {
            colorIndex = (colorIndex + 1) % colors.length;
            scene.background = colors[colorIndex];
            setTimeout(animateBackground, 3000); // Change background every 3 seconds
        }
        animateBackground();

        // Add lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 1); // soft white light
        scene.add(ambientLight);
        const pointLight = new THREE.PointLight(0xffffff, 2, 100);
        pointLight.position.set(25, 50, 25);
        scene.add(pointLight);

        // Create floating discount tags (circles)
        const createDiscountTag = (x, y, z, color) => {
            const geometry = new THREE.CircleGeometry(5, 32);
            const material = new THREE.MeshBasicMaterial({ color: color, emissive: color, emissiveIntensity: 1 });
            const tag = new THREE.Mesh(geometry, material);
            scene.add(tag);
            tag.position.set(x, y, z);

            // Animate floating and rotating tags
            let speed = Math.random() * 0.1 + 0.05;
            let rotationSpeed = Math.random() * 0.02 + 0.01;
            function moveTag() {
                tag.position.y += speed;
                tag.position.x += Math.sin(tag.rotation.y) * 0.05;
                tag.position.z += Math.cos(tag.rotation.y) * 0.05;

                tag.rotation.x += rotationSpeed;
                tag.rotation.y += rotationSpeed;
                if (tag.position.y > 30) {
                    tag.position.y = -30;
                }
                renderer.render(scene, camera);
                requestAnimationFrame(moveTag);
            }
            moveTag();
            return tag;
        };

        // Create flying tags with random positions and colors
        const tags = [];
        for (let i = 0; i < 20; i++) {
            let xPos = Math.random() * 60 - 30;
            let zPos = Math.random() * 60 - 30;
            let colors = [0xff5733, 0x33ff57, 0x3357ff, 0xff33cc, 0xffa500, 0x800080];
            const tag = createDiscountTag(xPos, -30, zPos, colors[Math.floor(Math.random() * colors.length)]);
            tags.push(tag);
        }

        // Set the camera position and orientation
        camera.position.z = 50;
        camera.position.y = 10;
        camera.lookAt(0, 10, 0);

        // Create orbit controls (optional for interactive camera movement)
        const controls = new THREE.OrbitControls(camera, renderer.domElement);

        // Raycaster setup for detecting mouse clicks
        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();

        // Mouse move event to update mouse position
        window.addEventListener('mousemove', (event) => {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;  // x between -1 and 1
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1; // y between -1 and 1
        });

        // Click event to trigger animation on clicked tag
        window.addEventListener('click', () => {
            raycaster.update();
            raycaster.setFromCamera(mouse, camera);
            const intersects = raycaster.intersectObjects(tags);

            if (intersects.length > 0) {
                const clickedTag = intersects[0].object;
                // Animate the clicked tag (scale it up and then back down)
                new TWEEN.Tween(clickedTag.scale)
                    .to({ x: 2, y: 2, z: 2 }, 500)  // Scale up over 0.5 seconds
                    .easing(TWEEN.Easing.Quadratic.Out)  // Smooth easing
                    .onComplete(() => {
                        new TWEEN.Tween(clickedTag.scale)
                            .to({ x: 1, y: 1, z: 1 }, 500)  // Scale back down
                            .easing(TWEEN.Easing.Quadratic.In)
                            .start();
                    })
                    .start();
            }
        });

        // Animate the scene
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
            controls.update();
            TWEEN.update();  // Update TWEEN animations
        }

        animate();

        // Handle window resizing
        window.addEventListener('resize', () => {
            renderer.setSize(window.innerWidth, window.innerHeight);
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
        });
    </script>

    <!-- Include TWEEN.js for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tween.js/18.6.4/Tween.min.js"></script>
</body>
</html>
