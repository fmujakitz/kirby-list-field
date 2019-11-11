<template>
  <k-field
    name="input-field"
    :label="label"
    >

    <k-draggable
      element="ul"
      :list="value"
      :options="{handle:'.list-item-handle', animation:150, forceFallback:true}"
      v-on:change="onSort"
    >
      <li v-for="(item, index) in value" v-bind:key="item">
        <k-icon 
          class="list-item-handle"
          :type="'sort'"
        />
        <span class="item-label">
          {{item}}
        </span>
        <k-button
          icon="remove"
          v-on:click="() => removeItem(index)"
        />
      </li>
    </k-draggable>

    <k-input
      name="text"
      type="textarea"
      theme="field"
      ref="textarea"
      v-model="text"
      :buttons="false"
      :placeholder="placeholder"
    />

    <k-button
      class="add-item"
      icon="add" 
      v-on:click="addItem"
      v-if="this.text"
    >
      {{this.$t('add')}}
    </k-button>

  </k-field>
</template>


<script>

export default {
  props: {
    label: String,
    placeholder: String,
    value: Array
  },
  data() {
    return ({
      text: '',
    })
  },
  methods: {
    addItem() {
      this.value.push(this.text)
      this.text = ''
      this.$emit('input', this.value)
      this.$refs.textarea.focus()
    },
    removeItem(index) {
      this.value.splice(index, 1)
      this.$emit('input', this.value)
    },
    onSort() {
      this.$emit('input', this.value)
    }
  }
};


</script>



<style lang="scss">
  // variables
  $border: 1px solid #ccc;
  $radius: 0.3em;
  $shadow: 0.1em 0.4em 1.2em rgba(0, 0, 0, 0.2);
  $padding: 0.5em;
  $transition: .2s ease-in-out;
  $blue: #81a2be;
  $green: #5d800d;
  
  // input field
  .k-field-name-input-field {
    display: flex;
    flex-flow: column;

    button.add-item {
      align-self: flex-end;
      padding: $padding;
      color: $blue;
      transition: color $transition;
      &:hover {
        color: $green;
      }
    }

    ul {
      margin-bottom: 0.75em;

      li {
        display: flex;
        background-color: white;
        border: $border;
        
        overflow: hidden;

        // borders
        &:not(:first-child) {
          border-top: none;
          span.list-item-handle { cursor: ns-resize; }
        }
        &:first-child {
          border-top-left-radius: $radius;
          border-top-right-radius: $radius;
          span.list-item-handle { cursor: s-resize; }
        }
        &:last-child {
          border-bottom-left-radius: $radius;
          border-bottom-right-radius: $radius;
          span.list-item-handle { cursor: n-resize; }
        }

        // text and button
        span {
          display: flex;
          padding: $padding;
        }
        span.list-item-handle {
          // padding: 0.75em $padding;
          // align-self: flex-start;
          opacity: 0.25;
          transition: opacity $transition;
          &:hover {
            opacity: 1;
          }
        }
        button:last-child {
          opacity: 0;
          transform: translateX(100%);
          transition: all $transition;
          cursor: pointer;
          z-index: 1;
        }

        span.item-label {
          flex: 1;
        }

        // hover and moving
        &:hover:not(.sortable-chosen) {
          button:last-child {
            opacity: 1;
            transform: translateX(0);
            transition-delay: .2s;
          }
        }
        &.k-sortable-ghost {
          background-color: rgba(255, 255, 255, 0.5);
          box-shadow: none;
          span { opacity: 0; }
        }

      }

      
    }
  }
  // sortable element created out of the field?
  .k-sortable-fallback {
    display: flex;
    background-color: white;
    border-radius: $radius;
    box-shadow: $shadow;
    span { padding: $padding; }
    span:last-child { display: none; }
  }
</style>
