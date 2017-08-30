<template>
  <el-form ref="form" :model="form" label-width="80px">

    <el-form-item label="发布频道">
      <el-cascader
        :options="typeOptions"
        @change="handleType">
      </el-cascader>
    </el-form-item>
    <el-form-item label="标签" v-if="isTag">
      <el-select v-model="form.tag_id" placeholder="请选择标签">
        <el-option
          v-for="item in tagOptions"
          :key="item.id"
          :label="item.tag_name"
          :value="item.id">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item label="标题">
      <el-input v-model="form.title"></el-input>
    </el-form-item>
    <el-form-item label="缩略图">
      <el-upload
        class="thumbnail-uploader"
        :action="action"
        :multiple="false"
        :show-file-list="false"
        :headers="headers"
        :on-success="handleThumbSuccess"
        :before-upload="beforeThumbUpload">
        <img v-if="form.thumbnail" :src="form.thumbnail" class="thumbnail">
        <i v-else class="el-icon-plus thumbnail-uploader-icon"></i>
      </el-upload>
    </el-form-item>
    <el-form-item label="简介">
      <el-input type="textarea" :rows="4" v-model="form.desc"></el-input>
    </el-form-item>
    <el-form-item label="内容"  v-if="!isTag">
      <quill-editor ref="myTextEditor" v-model="form.content" :config="editorOption" @ready="onEditorReady($event)"></quill-editor>
    </el-form-item>
    <el-form-item label="直接发布">
      <el-switch
        v-model="form.is_examine"
        on-text="是"
        off-text="否"
        off-value = '0'
        on-value = '1'>
      </el-switch>
      否则需要审核
    </el-form-item>
    <el-form-item label="是否置顶">
      <el-switch
        v-model="form.is_top"
        on-text="是"
        off-text="否"
        off-value = '0'
        on-value = '1'>
      </el-switch>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="submitForm('form')" :loading="loading">立即创建</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import { getTypeList, uploadFile, postArticle, getTag } from '@/api/article';
import { quillEditor } from 'vue-quill-editor';
import NProgress from 'nprogress';

export default {
  data() {
    return {
      form: {
        type_id: '',
        tag_id: '',
        title: '',
        thumbnail: '',
        desc: '',
        content: '',
        is_top: '0',
        is_examine: '1'
      },
      action: '/api/article/upload',
      headers: {
        Authorization:'Bearer '+this.$store.state.user.token,
        alg: 'HS256'
      },
      typeOptions: [],
      isTag: false,
      tagOptions: [],
      editor: null,
      editorOption: {},
      loading: false
    }
  },
  components: {
    quillEditor
  },
  created() {
    this.getType();
    this.getTag();
  },
  methods: {
    getType() {
      getTypeList().then(res => {
        this.typeOptions = res.data.result;
      })
    },
    getTag() {
      getTag().then(res => {
        this.tagOptions = res.data.result;
      })
    },
    handleType (v) {
      this.isTag = v[0] == 2 ? true : false;
      this.form.type_id = v[v.length - 1];
    },
    // 初始化quill图片事件
    onEditorReady(editor) {
      this.editor = editor;
      editor.getModule('toolbar').addHandler('image', () => {
        this.selectLocalImage();
      });
    },
    // quill选择本地图片
    selectLocalImage(){
      const input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.click();

      input.onchange = () => {
        const file = input.files[0];
        // file type is only image.
        if (/^image\//.test(file.type)) {
          this.saveToServer(file);
        } else {
          console.warn('You could only upload images.');
        }
      };
    },
    // 保存并上传服务器
    saveToServer(file) {
      // 上传进度
      NProgress.start();

      const fd = new FormData();
      fd.append('file', file);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', '/api/article/upload', true);
      xhr.setRequestHeader('Authorization', 'Bearer '+this.$store.state.user.token);
      xhr.setRequestHeader('alg', 'HS256');
      xhr.onload = () => {
        NProgress.done();
        if (xhr.status === 200) {
          // this is callback data: url
          const url = JSON.parse(xhr.responseText).result;
          this.insertToEditor(url);
        }
      };
      xhr.send(fd);

    },
    // 将图片URL插入编辑器
    insertToEditor(url) {
      // push image url to rich editor.
      const range = this.editor.getSelection();
      console.log(this.editor)
      this.editor.insertEmbed(range.index, 'image', url);
    },
    handleThumbSuccess(res, file) {
      this.form.thumbnail = file.response.result;
      NProgress.done();
    },
    beforeThumbUpload(file) {
      NProgress.start();
      let re = new RegExp('image');

      const isJPG = re.test(file.type);
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isJPG) {
        this.$message.error('上传缩略图只能是 JPG, PNG, GIF, JPEG 格式!');
      }
      if (!isLt2M) {
        this.$message.error('上传缩略图大小不能超过 2MB!');
      }
      if (isJPG && isLt2M) {
        return true;
      }
      NProgress.done();
      return false;
    },
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.loading = true;
          postArticle(this.form).then(res => {
            this.loading = false;
            let {code, msg} = res.data;
            if (code === 1) {
              return this.$message.error(msg);
            }
            this.$router.replace({path: '/article/history'});
            return this.$message.success(msg);
          })
        }
        return false;
      });
    },
  }
}
</script>

<style>
  .thumbnail-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .thumbnail-uploader .el-upload:hover {
    border-color: #20a0ff;
  }
  .thumbnail-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .thumbnail {
    width: 178px;
    height: 178px;
    display: block;
  }
  .el-form-item__content .ql-toolbar {
    line-height: normal;
  }
  .ql-editor {
    height: 350px;
  }
</style>
