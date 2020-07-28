<template>
    <div style="background:#ECECEC; padding:30px">
        <h1>Todo</h1>
        <a-button @click="showModalAdd">create New Todo</a-button>
        <br />
        <a-modal v-model="visibleAdd" title="Add todo" @ok="handleAdd">
            <p>Title</p>
            <a-input v-model="createTodo.title"></a-input>
            <p>Description</p>
            <a-input v-model="createTodo.description"></a-input>
         </a-modal>
         <br />
        <div v-for="todo in allTodo" :key="todo.id">
        <a-card hoverable style="width: 300px">
            <template slot="actions" class="ant-card-actions">
            <a-icon @click="handleDelete(todo.id)" key="delete" type="delete" />
            <a-icon @click="showModalEdit(todo.id)" key="edit" type="edit" />
            <a-icon key="check" type="check" />
            </template>
            <a-card-meta :title="todo.title" :description="todo.description">
            </a-card-meta>
        </a-card>
        <br />
        <a-modal v-model="visibleEdit" title="Edit todo" @ok="handleEdit">
                <p>Title </p>
                <a-input v-model="title"></a-input>
                <p>Description</p>
                <a-input v-model="description"></a-input>
            </a-modal>
        </div>
        
        
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name: "Todo",
    computed: mapGetters([
        'allTodo',
    ]),
    created(){
      this.fetchTodo();
  },
  methods: {
    ...mapActions(['fetchTodo', 'addTodo', 'deleteTodo']),
    showModalAdd(){
        this.visibleAdd = true
    },
    showModalEdit(idTodo){
        this.visibleEdit = true
    },
    handleAdd(e){
        e.preventDefault();
        this.addTodo(this.createTodo)
        this.visibleAdd=false
    },
    handleEdit(e){
        e.preventDefault();
        this.visibleEdit=false
    },
    handleDelete(todoId){
        if(confirm('Do you want to delete this todo?'))
            this.deleteTodo(todoId)
            .then(response => {
                <template>
                    <a-alert message="Delete Success!" type="success" />
                </template>
            })
            .catch(error => {
                <template>
                    <a-alert message="Delete Failed! Some thing went wrong!" type="error" />
                </template>
                console.log(error)
            })
    }
  },
  data(){
      return{
          visibleAdd: false,
          visibleEdit: false,
          id: 0,
          title: '',
          description: '',
          createTodo: {
              title: '',
              description: ''
          }
      }
  }
}
</script>