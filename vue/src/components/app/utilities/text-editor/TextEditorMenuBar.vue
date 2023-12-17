<template>
    <div v-if="editor" class="buttons d-flex flex-wrap align-items-center">
        <button class="ms-auto" @click="editor.chain().focus().toggleBold().run()" :class="{ 'active' : editor.isActive('bold') }">
            <font-awesome-icon icon="fa-solid fa-bold" />
        </button>
        <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'active' : editor.isActive('italic') }">
            <font-awesome-icon icon="fa-solid fa-italic" />
        </button>
        <button @click="editor.chain().focus().toggleUnderline().run()" :class="{ 'active' : editor.isActive('underline') }">
            <font-awesome-icon icon="fa-solid fa-underline" />
        </button>
        
        <!-- Alignment -->
        <button @click="editor.chain().focus().setTextAlign('left').run()" :class="{ 'active' : editor.isActive({ textAlign: 'left'}) }">
            <font-awesome-icon icon="fa-solid fa-align-left" />
        </button>
        <button @click="editor.chain().focus().setTextAlign('center').run()" :class="{ 'active' : editor.isActive({ textAlign: 'center'}) }">
            <font-awesome-icon icon="fa-solid fa-align-center" />
        </button>
        <button @click="editor.chain().focus().setTextAlign('right').run()" :class="{ 'active' : editor.isActive({ textAlign: 'right'}) }">
            <font-awesome-icon icon="fa-solid fa-align-right" />
        </button>
        <button @click="editor.chain().focus().setTextAlign('justify').run()" :class="{ 'active' : editor.isActive({ textAlign: 'justify'}) }">
            <font-awesome-icon icon="fa-solid fa-align-justify" />
        </button>
        
        <!-- Font Color Picker -->
        
        <!-- Font Highlight -->
        
        <!-- Headings -->
        <button @click="editor.chain().focus().setHeading({ level: 1 }).run()" :class="{ 'active' : editor.isActive('heading', { level: 1 }) }">
            <font-awesome-icon icon="fa-solid fa-heading" />1
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'active' : editor.isActive('heading', { level: 2 }) }">
            <font-awesome-icon icon="fa-solid fa-heading" />2
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'active' : editor.isActive('heading', { level: 3 }) }">
            <font-awesome-icon icon="fa-solid fa-heading" />3
        </button>
        
        <!-- Paragraph -->
        <button @click="editor.chain().focus().setParagraph().run()" :class="{ 'active' : editor.isActive('paragraph') }">
            <font-awesome-icon icon="fa-solid fa-paragraph" />
        </button>

        <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'active' : editor.isActive('bulletList') }">
            <font-awesome-icon icon="fa-solid fa-list-ul" />
        </button>
        <button @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'active' : editor.isActive('orderedList') }">
            <font-awesome-icon icon="fa-solid fa-list-ol" />
        </button>
        <!-- <button @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'active' : editor.isActive('blockquote') }">
            <font-awesome-icon icon="fa-solid fa-block-quote" />
        </button> -->
        <button @click="editor.chain().focus().setHorizontalRule().run()">
            <!-- <font-awesome-icon icon="fa-solid fa-horizontal-rule" /> -->
            HR
        </button>

        <button @click="editor.chain().focus().undo().run()">
            <font-awesome-icon icon="fa-solid fa-rotate-left" />
        </button>
        <button class="me-auto" @click="editor.chain().focus().redo().run()">
            <font-awesome-icon icon="fa-solid fa-rotate-right" />
        </button>
        <div class="character-count text-white ms-auto me-3">
            {{ editor.storage.characterCount.words() }} words
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Editor } from '@tiptap/vue-3';


const props = defineProps({
    editor: {
        type: Editor,
        value: null
    }
})

const emit = defineEmits(['update:modelValue'])

</script>