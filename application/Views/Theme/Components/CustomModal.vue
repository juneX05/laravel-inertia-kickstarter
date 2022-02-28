<template>

  <div class="modal fade" :id="id">
    <div class="modal-dialog" v-bind:class="getModalType">
      <div :class="'modal-content ' + 'bg-' + this.color">
        <div class="modal-header">
          <h4 class="modal-title">
            {{title}}
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <slot name="body"></slot>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-light" :id="id + '_close'" data-dismiss="modal">Close</button>
          <slot name="action_button"></slot>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  export default {
    props:{
      id: String,
      type: {
        type: String,
        default: 'normal',
      },
      title:String,
      color:String,
    },
    computed:{
      getModalType() {
        return {
          'modal-lg' : this.type === 'lg',
          'modal-sm' : this.type === 'sm',
          'modal-xl' : this.type === 'xl',
        }
      },
    }

  }
</script>