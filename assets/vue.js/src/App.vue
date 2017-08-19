<template>
  <div id="app">
    <transition name="fold">
      <router-view></router-view>
    </transition>
  </div>
</template>

<style>
html, body {
  padding: 0;
  margin: 0;
}
.fold-enter-active {
  animation-name: fold-in;
  animation-duration: .5s;
}
.fold-leave-active {
  animation-name: fold-out;
  animation-duration: .5s;
}
@keyframes fold-in {
  0% {
    transform: translate3d(0, 100%, 0);
  }
  100% {
    transform: translate3d(0, 0, 0);
  }
}
@keyframes fold-out {
  0% {
    transform: translate3d(0, 0, 0);
  }
  100% {
    transform: translate3d(0, 100%, 0);
  }
}
</style>


<script>
export default {
  name: 'app'
}
</script>
