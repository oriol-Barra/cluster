<template>
  <div>
    <div class="editor-menu">
      <!-- Botones de ejemplo para funcionalidades básicas -->
      <button @click="toggleBold">Bold</button>
      <button @click="toggleItalic">Italic</button>
      <button @click="toggleUnderline">Underline</button>
    </div>
    <div ref="editorContent" class="editor-content"></div>
  </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

export default {
  name: 'TiptapEditor',
  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const editorContent = ref(null);
    let editor = null;

    // Inicializar el editor
    onMounted(() => {
      editor = new Editor({
        element: editorContent.value,
        extensions: [StarterKit],
        content: props.modelValue, // Cargar el valor inicial
        onUpdate: ({ editor }) => {
          emit('update:modelValue', editor.getHTML()); // Emitir cambios
        },
      });
    });

    // Limpiar el editor al desmontar
    onBeforeUnmount(() => {
      if (editor) {
        editor.destroy();
      }
    });

    // Funciones para los botones
    const toggleBold = () => editor.chain().focus().toggleBold().run();
    const toggleItalic = () => editor.chain().focus().toggleItalic().run();
    const toggleUnderline = () => editor.chain().focus().toggleUnderline().run();

    return { editorContent, toggleBold, toggleItalic, toggleUnderline };
  },
};
</script>

<style>
.editor-menu {
  margin-bottom: 10px;
}
.editor-menu button {
  margin-right: 5px;
  padding: 5px 10px;
}
.editor-content {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 4px;
  min-height: 150px;
}
</style>
