
const getVertexShaderSource = async () => fetch('./Shaders/vertex_shader.glsl').then(res => res.text())
const getFragmentShaderSource = async () => fetch('./Shaders/fragment_shader.glsl').then(res => res.text())
