#ifdef GL_FRAGMENT_PRECISION_HIGH
precision highp float;
#else
precision mediump float;
#endif

uniform sampler2D u_texture;
uniform float fColorCoef;
varying vec2 v_texcoord;
uniform vec4 color;


void main() {
    gl_FragColor = color * fColorCoef + texture2D(u_texture, v_texcoord) * (1.0 - fColorCoef);
}
