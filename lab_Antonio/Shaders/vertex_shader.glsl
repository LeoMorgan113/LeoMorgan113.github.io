attribute vec3 vertex;
attribute vec2 texCoord;
uniform mat4 ModelViewProjectionMatrix;
varying vec2 v_texcoord;

void main() {
    gl_Position = ModelViewProjectionMatrix * vec4(vertex, 1.0);
    v_texcoord = texCoord;
}
