<template>
    <div v-if="show" class="toast-message" :class="[typeClass]">
      {{ message }}
    </div>
  </template>

  <script>
  export default {
    props: {
      message: {
        type: String,
        required: true
      },
      type: {
        type: String,
        default: 'info',
        validator: value => ['info', 'success', 'warning', 'error'].includes(value)
      },
      duration: {
        type: Number,
        default: 3000 // 3 seconds
      }
    },
    data() {
      return {
        show: false
      };
    },
    computed: {
      typeClass() {
        return `toast-${this.type}`;
      }
    },
    mounted() {
      this.show = true;
      setTimeout(() => {
        this.show = false;
      }, this.duration);
    }
  };
  </script>

  <style scoped>
  .toast-message {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 12px 20px;
    border-radius: 4px;
    color: #fff;
    font-size: 14px;
    z-index: 1000;
  }

  .toast-info {
    background-color: #3490dc;
  }

  .toast-success {
    background-color: #38a169;
  }

  .toast-warning {
    background-color: #f6993f;
  }

  .toast-error {
    background-color: #e3342f;
  }
  </style>
