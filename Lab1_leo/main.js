'use strict';

let gl;                      
let iAttribVertex;          
let iAttribTexture;             
let iColor;                  
let iColorCoef;                
let iModelViewProjectionMatrix; 
let iTextureMappingUnit;
let iVertexBuffer;              
let iIndexBuffer;              
let iTexBuffer;                
let spaceball;                 
let isWireFrame = false;
let distance = 8;
let radiusInput,radiusRange, amplitudeInput, amplitudeRange, verticesInput, verticesRange;

const DEG_TO_RAD = Math.PI / 180;

let deviceOrientation = {
    alpha: 0,
    beta: 90,
    gamma: 0
}


class StereoCamera {
    constructor(
        Convergence,
        EyeSeparation,
        AspectRatio,
        FOV,
        NearClippingDistance,
        FarClippingDistance
    ) {
        this.mConvergence = Convergence;
        this.mEyeSeparation = EyeSeparation;
        this.mAspectRatio = AspectRatio;
        this.mFOV = FOV * Math.PI / 180.0
        this.mNearClippingDistance = NearClippingDistance;
        this.mFarClippingDistance = FarClippingDistance;
    }

    getLeftFrustum = function () {
        const top = this.mNearClippingDistance * Math.tan(this.mFOV / 2);
        const bottom = -top;

        const a = this.mAspectRatio * Math.tan(this.mFOV / 2) * this.mConvergence;
        const b = a - this.mEyeSeparation / 2;
        const c = a + this.mEyeSeparation / 2;

        const left = -b * this.mNearClippingDistance / this.mConvergence;
        const right = c * this.mNearClippingDistance / this.mConvergence;

        const projection = m4.frustum(left, right, bottom, top, this.mNearClippingDistance, this.mFarClippingDistance);
        const translation = m4.translation(this.mEyeSeparation / 2 / 100, 0, 0);

        return m4.multiply(projection, translation)
    }

    getRightFrustum = function () {
        const top = this.mNearClippingDistance * Math.tan(this.mFOV / 2);
        const bottom = -top;

        const a = this.mAspectRatio * Math.tan(this.mFOV / 2) * this.mConvergence;
        const b = a - this.mEyeSeparation / 2;
        const c = a + this.mEyeSeparation / 2;

        const left = -c * this.mNearClippingDistance / this.mConvergence;
        const right = b * this.mNearClippingDistance / this.mConvergence;

        const projection = m4.frustum(left, right, bottom, top, this.mNearClippingDistance, this.mFarClippingDistance);
        const translation = m4.translation(-this.mEyeSeparation / 2 / 100, 0, 0);

        return m4.multiply(projection, translation)
    }
}

function getRotationMatrix(alpha, beta, gamma) {
    const _x = beta ? beta * DEG_TO_RAD : 0; // beta value
    const _y = gamma ? gamma * DEG_TO_RAD : 0; // gamma value
    const _z = alpha ? alpha * DEG_TO_RAD : 0; // alpha value

    const cX = Math.cos(_x);
    const cY = Math.cos(_y);
    const cZ = Math.cos(_z);
    const sX = Math.sin(_x);
    const sY = Math.sin(_y);
    const sZ = Math.sin(_z);

    //
    // ZXY rotation matrix construction.
    //

    const m11 = cZ * cY - sZ * sX * sY;
    const m12 = -cX * sZ;
    const m13 = cY * sZ * sX + cZ * sY;

    const m21 = cY * sZ + cZ * sX * sY;
    const m22 = cZ * cX;
    const m23 = sZ * sY - cZ * cY * sX;

    const m31 = -cX * sY;
    const m32 = sX;
    const m33 = cX * cY;

    // return [
    //     m11, m12, m13,
    //     m21, m22, m23,
    //     m31, m32, m33,
    // ];

    return [
        m11, m12, m13, 0,
        m21, m22, m23, 0,
        m31, m32, m33, 0,
        0, 0, 0, 1
    ];
}


function drawPrimitive(primitiveType, color, vertices, texCoords) {
    gl.uniform4fv(iColor, color);
    gl.uniform1f(iColorCoef, 0.0);

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
        gl.uniform1f(iColorCoef, 1.0);
    }

    gl.drawArrays(primitiveType, 0, vertices.length / 3);
}


/* Draws a colored cube, along with a set of coordinate axes.
 * (Note that the use of the above drawPrimitive function is not an efficient
 * way to draw with WebGL.  Here, the geometry is so simple that it doesn't matter.)
 */
function draw() {
    _resizeCanvasToDisplaySize(gl.canvas);
    gl.viewport(0, 0, gl.canvas.width, gl.canvas.height);

    gl.clearColor(0, 0, 0, 1);
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

     const cam = new StereoCamera(
        2000.0,
        0, // eyeSeparation
        1,
        45.0,
        1.0,
        200000.0
    );

    let translateToPointZero = m4.translation(0, 0, -10);

    // let matAccum0 = m4.multiply(rotateToPointZero, modelView);
    let matAccum1 = m4.multiply(translateToPointZero, getRotationMatrix(deviceOrientation.alpha, deviceOrientation.beta, deviceOrientation.gamma));

    /* Multiply the projection matrix times the modelview matrix to give the
       combined transformation matrix, and send that to the shader program. */
    const modelViewProjectionL = m4.multiply(cam.getLeftFrustum(), matAccum1);
    const modelViewProjectionR = m4.multiply(cam.getRightFrustum(), matAccum1);

    gl.uniformMatrix4fv(iModelViewProjectionMatrix, false, modelViewProjectionL);
    gl.uniform1i(iTextureMappingUnit, 0);
    gl.colorMask(true, false, false, false);

    gl.clear(gl.DEPTH_BUFFER_BIT);

    // Right
    gl.uniformMatrix4fv(iModelViewProjectionMatrix, false, modelViewProjectionR);
    gl.uniform1i(iTextureMappingUnit, 0);
    gl.colorMask(false, true, true, false);

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
    gl.uniform1f(iColorCoef, 0.0);

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
        gl.uniform1f(iColorCoef, 1.0);

        gl.drawElements(gl.LINES, indices.length, gl.UNSIGNED_SHORT, 0);
    } else {
        gl.enableVertexAttribArray(iAttribTexture);
        gl.bindBuffer(gl.ARRAY_BUFFER, iTexBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(texCoords), gl.STREAM_DRAW);
        gl.vertexAttribPointer(iAttribTexture, 2, gl.FLOAT, false, 0, 0);

        gl.drawElements(gl.TRIANGLES, indices.length, gl.UNSIGNED_SHORT, 0);
    }

    gl.colorMask(true, true, true, true);

    /* Draw coordinate axes as thick colored lines that extend through the cube. */
    gl.lineWidth(4);
    drawPrimitive(gl.LINES, [1, 0, 0, 1], [-2, 0, 0, 2, 0, 0]);
    drawPrimitive(gl.LINES, [0, 1, 0, 1], [0, -2, 0, 0, 2, 0]);
    drawPrimitive(gl.LINES, [0, 0, 1, 1], [0, 0, -2, 0, 0, 2]);
    gl.lineWidth(1);
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
    iColorCoef = gl.getUniformLocation(prog, "fColorCoef");
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
    image.src = "https://webglfundamentals.org/webgl/resources/f-texture.png";
    image.addEventListener('load', () => {
        // Now that the image has loaded make copy it to the texture.
        gl.bindTexture(gl.TEXTURE_2D, texture);
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, image);

        draw();
    });
}

/* Creates a program for use in the WebGL context gl, and returns the
 * identifier for that program.  If an error occurs while compiling or
 * linking the program, an exception of type Error is thrown.  The error
 * string contains the compilation or linking error.  If no error occurs,
 * the program identifier is the return value of the function.
 * The second and third parameters are strings that contain the
 * source code for the vertex shader and for the fragment shader.
 */
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


/**
 * initialization function that will be called when the page has loaded
 */
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

    window.addEventListener('deviceorientation', (e) => {
        deviceOrientation.alpha = e.alpha;
        deviceOrientation.beta = e.beta;
        deviceOrientation.gamma = e.gamma;
        draw()
    })

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

    spaceball = new TrackballRotator(canvas, draw, 0);
    draw();
}





