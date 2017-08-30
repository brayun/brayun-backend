<template>
    <el-row class="container">
        <head-nav></head-nav>
        <el-col :span="24" class="main">
            <slider-nav></slider-nav>
            <div class="main-container">
      				<div class="main-frame">
      					<transition name="fade" mode="out-in">
      						<router-view></router-view>
      					</transition>
      				</div>
      			</div>
        </el-col>
    </el-row>
</template>

<script>
import HeadNav from './partial/HeadNav'
import SliderNav from './partial/SliderNav'
export default {
    data() {
        return {

        }
    },
    components: {
        HeadNav,
        SliderNav
    }
}
</script>

<style lang="scss">
@import '../assets/scss/style.scss';
.container {
  position: absolute;
  bottom: 0;
  top: 0;
  width: 100%;
}


.main {
  display: flex;
  position: absolute;
  top: 60px;
  bottom: 0;
  overflow: hidden;
  background-color: #f5f8f9;

  .main-container {
    flex: 1;
    overflow-y: scroll;

    .main-frame {
      padding: 10px;

      .main-content {
        background-color: #fff;
        padding: 15px;
      }
    }
  }
}

</style>
