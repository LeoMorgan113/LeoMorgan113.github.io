'use strict';

let gl;                         // The webgl context.
let iAttribVertex;              // Location of the attribute variable in the shader program.
let iAttribTexture;             // Location of the attribute variable in the shader program.
let iColor;                     // Location of the uniform specifying a color for the primitive.
let iColordegree;                 // Location of the uniform specifying a color for the primitive.
let iModelViewProjectionMatrix; // Location of the uniform matrix representing the combined transformation.
let iTextureMappingUnit;
let iVertexBuffer;              // Buffer to hold the values.
let iIndexBuffer;              // Buffer to hold the values.
let iTexBuffer;                 // Buffer to hold the values.
let spaceball;                  // A SimpleRotator object that lets the user rotate the view by mouse.
let isWireFrame = false;
let distance = 4;
let radiusInput,radiusRange, amplitudeInput, amplitudeRange, verticesInput, verticesRange;

let devOrientation = {
    alpha: 0,
    beta: 0,
    gamma: 0
}
const degree = Math.PI / 180;


function setDeviceOrientation(alpha, beta, gamma) {
    const x1 = Math.cos(beta ? beta * degree : 0);
    const y1 = Math.cos(gamma ? gamma * degree : 0);
    const z1 = Math.cos(alpha ? alpha * degree : 0);
    const x2 = Math.sin(beta ? beta * degree : 0);
    const y2 = Math.sin(gamma ? gamma * degree : 0);
    const z2 = Math.sin(alpha ? alpha * degree : 0);

    let coord11 = z1 * y1 - z2 * x2 * y2;
    let coord12 = -x1 * z2;
    let coord13 = y1 * z2 * x2 + z1 * y2;

    let coord21 = y1 * z2 + z1 * x2 * y2;
    let coord22 = z1 * x1;
    let coord23 = z2 * y2 - z1 * y1 * x2;

    let coord31 = -x1 * y2;
    let coord32 = x2;
    let coord33 = x1 * y1;

    return [
        coord11, coord12, coord13, 0,
        coord21, coord22, coord23, 0,
        coord31, coord32, coord33, 0,
        0, 0, 0, 1
    ];
}

function drawPrimitive(primitiveType, color, vertices, texCoords) {
    gl.uniform4fv(iColor, color);
    gl.uniform1f(iColordegree, 0.0);

    gl.enableVertexAttribArray(iAttribVertex);
    gl.bindBuffer(gl.ARRAY_BUFFER, iVertexBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STREAM_DRAW);
    gl.vertexAttribPointer(iAttribVertex, 3, gl.FLOAT, false, 0, 0);

    if (texCoords) {
        gl.enableVertexAttribArray(iAttribTexture);
        gl.bindBuffer(gl.ARRAY_BUFFER, iTexBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(texCoords), gl.STREAM_DRAW);
        gl.vertexAttribPointer(iAttribTexture, 2, gl.FLOAT, false, 0, 0);
    } else {
        gl.disableVertexAttribArray(iAttribTexture);
        gl.vertexAttrib2f(iAttribTexture, 0.0, 0.0);
        gl.uniform1f(iColordegree, 1.0);
    }

    gl.drawArrays(primitiveType, 0, vertices.length / 3);
}

function drawCloverKnot(){
    const vertices = []
    const texCoords = []
    const indices = []

    const r = parseFloat(radiusInput.value);
    const a = parseFloat(amplitudeInput.value);
    const n = parseInt(verticesInput.value);

    for (let j = 0; j <= n; j++) {
        let u1 = j / n;

        for (let i = 0; i <= n; i++) {
            let v1 = i / n;
            let u = u1 * Math.PI * 12;
            let v = v1 * Math.PI * 2;

            let x = (r + a * Math.cos(u / 2)) * Math.cos(u / 3) + a * Math.cos(u / 3) * Math.cos(v - Math.PI);
            let y = (r + a * Math.cos(u / 2)) * Math.sin(u / 3) + a * Math.sin(u / 3) * Math.cos(v - Math.PI);
            let z = a + Math.sin(u / 2) + a * Math.sin(v - Math.PI);

            vertices.push(x);  // X
            vertices.push(y);  // Y
            vertices.push(z);  // Z

            const s = j / n;
            const t = i / n;
            texCoords.push(s);
            texCoords.push(t);
        }
    }

    for (let j = 0; j < n; j++) {
        for (let i = 0; i < n; i++) {
            const index1 = j * (n + 1) + i;
            const index2 = index1 + (n + 1);
            indices.push(index1);
            indices.push(index2);
            indices.push(index1 + 1);
            indices.push(index1 + 1);
            indices.push(index2);
            indices.push(index2 + 1);
        }
    }

    gl.uniform4fv(iColor, [0.1, 0.2, 0.7, 1]);
    gl.uniform1f(iColordegree, 0.0);

    // vertices
    gl.bindBuffer(gl.ARRAY_BUFFER, iVertexBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STREAM_DRAW);

    // indices
    gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, iIndexBuffer);
    gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(indices), gl.STREAM_DRAW);

    // textures
    if (isWireFrame) {
        gl.disableVertexAttribArray(iAttribTexture);
        gl.vertexAttrib2f(iAttribTexture, 0.0, 0.0);
        gl.uniform1f(iColordegree, 1.0);

        gl.drawElements(gl.LINES, indices.length, gl.UNSIGNED_SHORT, 0);
    } else {
        gl.enableVertexAttribArray(iAttribTexture);
        gl.bindBuffer(gl.ARRAY_BUFFER, iTexBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(texCoords), gl.STREAM_DRAW);
        gl.vertexAttribPointer(iAttribTexture, 2, gl.FLOAT, false, 0, 0);

        gl.drawElements(gl.TRIANGLES, indices.length, gl.UNSIGNED_SHORT, 0);
    }

    drawPrimitive(gl.LINES, [0, 0, 1, 1], [0, 0, -2, 0, 0, 2]);
}

function draw() {
    _resizeCanvasToDisplaySize(gl.canvas);
    gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);
    gl.clearColor(0, 0, 0, 1);
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

    
    let mainProjection = m4.perspective(Math.PI / distance, 2, 2, 14);
    let translateToPointZero = m4.translation(0, 0, -10);

    let matAccum1 = m4.multiply(translateToPointZero, setDeviceOrientation(devOrientation.alpha, devOrientation.beta, devOrientation.gamma));

    let modelViewProjection = m4.multiply(mainProjection, matAccum1);

    gl.uniformMatrix4fv(iModelViewProjectionMatrix, false, modelViewProjection);
    gl.uniform1i(iTextureMappingUnit, 0);


    //drawing Clover Knot
    drawCloverKnot();
}

function _resizeCanvasToDisplaySize(canvas) {
    const dpr = window.devicePixelRatio;
    // Lookup the size the browser is displaying the canvas in CSS pixels.
    const {width, height} = canvas.getBoundingClientRect();
    const displayWidth = Math.round(width * dpr);
    const displayHeight = Math.round(height * dpr);

    // Check if the canvas is not the same size.
    const needResize = canvas.width !== displayWidth ||
        canvas.height !== displayHeight;

    if (needResize) {
        // Make the canvas the same size
        canvas.width = displayWidth;
        canvas.height = displayHeight;
    }
    return needResize;
}


/* Initialize the WebGL context. Called from init() */
async function initGL() {
    let prog = createProgram(gl, vertexShaderSource, fragmentShaderSource );
    gl.useProgram(prog);

    iAttribVertex = gl.getAttribLocation(prog, "vertex");
    iAttribTexture = gl.getAttribLocation(prog, "texCoord");

    iModelViewProjectionMatrix = gl.getUniformLocation(prog, "ModelViewProjectionMatrix");
    iColor = gl.getUniformLocation(prog, "color");
    iColordegree = gl.getUniformLocation(prog, "fColordegree");
    iTextureMappingUnit = gl.getUniformLocation(prog, "u_texture");

    iVertexBuffer = gl.createBuffer();
    iIndexBuffer = gl.createBuffer();
    iTexBuffer = gl.createBuffer();

    LoadTexture();

    gl.enable(gl.DEPTH_TEST);


}

function LoadTexture() {
    // Create a texture.
    const texture = gl.createTexture();
    gl.bindTexture(gl.TEXTURE_2D, texture);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);

    // Fill the texture with a 1x1 blue pixel.
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, 1, 1, 0, gl.RGBA, gl.UNSIGNED_BYTE, new Uint8Array([0, 0, 255, 255]));
    const image = new Image();
    image.crossOrigin = 'anonymous';
    image.src = "texture.png";
    image.addEventListener('load', () => {
        // Now that the image has loaded make copy it to the texture.
        gl.bindTexture(gl.TEXTURE_2D, texture);
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image);

        draw();
    });
}

function createProgram(gl, vShader, fShader) {
    let vsh = gl.createShader(gl.VERTEX_SHADER);
    gl.shaderSource(vsh, vShader);
    gl.compileShader(vsh);
    if (!gl.getShaderParameter(vsh, gl.COMPILE_STATUS)) {
        throw new Error("Error in vertex shader:  " + gl.getShaderInfoLog(vsh));
    }
    let fsh = gl.createShader(gl.FRAGMENT_SHADER);
    gl.shaderSource(fsh, fShader);
    gl.compileShader(fsh);
    if (!gl.getShaderParameter(fsh, gl.COMPILE_STATUS)) {
        throw new Error("Error in fragment shader:  " + gl.getShaderInfoLog(fsh));
    }
    let prog = gl.createProgram();
    gl.attachShader(prog, vsh);
    gl.attachShader(prog, fsh);
    gl.linkProgram(prog);
    if (!gl.getProgramParameter(prog, gl.LINK_STATUS)) {
        throw new Error("Link error in program:  " + gl.getProgramInfoLog(prog));
    }

    return prog;
}


async function init() {
    radiusInput = document.getElementById('radiusInput');
    radiusRange = document.getElementById('radiusRange');
    amplitudeInput = document.getElementById('amplitudeInput');
    amplitudeRange = document.getElementById('amplitudeRange');
    verticesInput = document.getElementById('verticesInput');
    verticesRange = document.getElementById('verticesRange');

    radiusRange.addEventListener('input', () => {
        radiusInput.value = radiusRange.value;
        draw();
    });
    radiusInput.addEventListener('change', () => {
        radiusRange.value = radiusInput.value;
        draw();
    });
    amplitudeRange.addEventListener('input', () => {
        amplitudeInput.value = amplitudeRange.value;
        draw();
    });
    amplitudeInput.addEventListener('change', () => {
        amplitudeRange.value = amplitudeInput.value;
        draw();
    });
    verticesRange.addEventListener('input', () => {
        verticesInput.value = verticesRange.value;
        draw();
    });
    verticesInput.addEventListener('change', () => {
        verticesRange.value = verticesInput.value;
        draw();
    });

    let canvas;
    try {
        canvas = document.getElementById("canvas");
        gl = canvas.getContext("webgl");
        if (!gl) {
            throw "Browser does not support WebGL";
        }
    } catch (e) {
        document.getElementById("canvas-holder").innerHTML =
            "<p>Sorry, could not get a WebGL graphics context.</p>";
        document.getElementById('banner').hidden = true;
        return;
    }
    try {
        await initGL();  // initialize the WebGL graphics context
    } catch (e) {
        document.getElementById("canvas-holder").innerHTML =
            "<p>Sorry, could not initialize the WebGL graphics context: " + e + "</p>";
        document.getElementById('banner').hidden = true;
        return;
    }

    window.addEventListener('deviceorientation', (e) => {
        devOrientation.alpha = e.alpha;
        devOrientation.beta = e.beta;
        devOrientation.gamma = e.gamma;
        draw()
    })

    spaceball = new TrackballRotator(canvas, draw, 0);
    draw();
}





