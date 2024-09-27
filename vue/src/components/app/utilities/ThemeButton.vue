<script>
export default {
  mounted() {
    const initUserTheme = this.getTheme() || this.getMediaPreference();
    this.setTheme(initUserTheme);
  },

  data() {
    return {
      userTheme: "light",
    };
  },

  methods: {
    toggleTheme() {
      const activeTheme = localStorage.getItem("user-theme");
      if (activeTheme === "light") {
        this.setTheme("dark");
      } else {
        this.setTheme("light");
      }
    },

    getTheme() {
      return localStorage.getItem("user-theme");
    },

    setTheme(theme) {
      localStorage.setItem("user-theme", theme);
      this.userTheme = theme;
      if (document.querySelector('#page-content-wrapper') != null) {
        document.querySelector('#page-content-wrapper').className = theme;
      }
    },

    getMediaPreference() {
      const hasDarkPreference = window.matchMedia(
        "(prefers-color-scheme: dark)"
      ).matches;
      if (hasDarkPreference) {
        return "dark";
      } else {
        return "light";
      }
    },
  },
};
</script>

<template>
    <input
        @change="toggleTheme"
        id="checkbox"
        type="checkbox"
        role="switch"
        class="switch-checkbox"
    />
    <label for="checkbox" class="switch-label text-center mx-auto">
        <span>🌙</span>
        <span>☀️</span>
        <div class="switch-toggle" :class="{ 'switch-toggle-checked': userTheme === 'dark' }"></div>
    </label>
</template>

<style scoped>
.switch-checkbox {
  display: none;
}

.switch-label {
  align-items: center;
  background: var(--light);
  border: calc(4rem * 0.025) solid var(--dark);
  border-radius: 4rem;
  cursor: pointer;
  display: flex;
  font-size: calc(4rem * 0.3);
  height: calc(6rem * 0.35);
  position: relative;
  padding: calc(4rem * 0.1);
  transition: background 0.5s ease;
  justify-content: space-between;
  width: 4.5rem;
  z-index: 1;
}

.switch-toggle {
  position: absolute;
  background-color: var(--primary);
  border-radius: 50%;
  top: calc(4rem * 0.04);
  left: calc(4rem * 0.15);
  height: calc(4rem * 0.4);
  width: calc(4rem * 0.4);
  transform: translateX(0);
  transition: transform 0.3s ease, background-color 0.5s ease;
}

.switch-toggle-checked {
  transform: translateX(calc(4rem * 0.45)) !important;
}
</style>