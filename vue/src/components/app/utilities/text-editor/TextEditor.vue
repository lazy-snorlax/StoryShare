<template>
    <div class="wysiwyg-container">
      <TextEditorMenuBar v-if="showMenuBar" :editor="editor" />
      <editor-content :editor="editor" />
    </div>
</template>
  
<script lang="ts" setup>
  import { useEditor, EditorContent } from '@tiptap/vue-3'
  import TextEditorMenuBar from './TextEditorMenuBar.vue'

  import StarterKit from '@tiptap/starter-kit'
  import Heading from '@tiptap/extension-heading'
  import Paragraph from '@tiptap/extension-paragraph'
  import Underline from '@tiptap/extension-underline'
  import TextAlign from '@tiptap/extension-text-align'
  import CharacterCount from '@tiptap/extension-character-count'
  
  const props = defineProps({
    showMenuBar: {
      type: Boolean, default: true
    },
    modelValue: {
      type: String || null
    }
  })
  
  const emit = defineEmits<{
    (e: 'update:modelValue', modelValue: string) : void
    (e: 'words', wordCount: number) : void
  }>()
    
  const editor = useEditor({
    content: props.modelValue,
    onUpdate: ({ editor }) => {
      emit('update:modelValue', editor.getHTML())
      emit('words', editor.storage.characterCount.words())
    },
    extensions: [
      StarterKit,
      Underline,
      Heading.configure({
        levels: [ 1, 2, 3],
      }),
      Paragraph.configure({
        HTMLAttributes: {
          class: 'text-white'
        }
      }),
      TextAlign.configure({
        types: ['heading', 'paragraph'],
      }),
      CharacterCount.configure({
        mode: 'nodeSize'
      }),
    ],
    editorProps: {
      attributes: {
        class: 'editor',
      }
    },
  })
</script>

<style lang="scss">
.editor {
  background-color: var(--dark);
  margin-bottom: 1rem;
  padding: 1rem;
  border: var(--light-alt) 1px solid;
  // border-top: none;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  min-height: 12rem;
  max-height: 12rem;
  overflow: scroll;
  &:focus {
    border-color: var(--light-alt);
  }
}

.buttons {
  border: var(--light-alt) 1px solid;
  border-radius: 10px 10px 0 0;
  button {
    border: var(--light-alt) 1px solid;
    border-radius: 10px;
    color: var(--white);
    padding: 0.5rem 1rem;
    margin: 0.5rem;
    &:hover {
      background-color: var(--light-alt);
      color: var(--black);
    }
  }
  .active {
    background-color: var(--light-alt);
    color: var(--black);
  }
}

</style>