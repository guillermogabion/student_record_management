<template>
  <v-data-table
    :headers="headers"
    :items="students"
    sort-by="calories"
    class="elevation-1"
    :search="search"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Student Records</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-text-field
        append-icon="mdi-magnify"
        v-model="search"
        flat
        ></v-text-field>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          width="1000px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              New Student
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                   <v-col
                   cols="12"
                    sm="6"
                    md="12">
                    <label>Student Information</label>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.last_name"
                      label="Last Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.first_name"
                      label="First Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.mid_name"
                      label="Middle Initial"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.suffix"
                      label="Suffix"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.stud_no"
                      label="Student_no"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.program"
                      label="Program"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.dobirth"
                      label="Date of Birth"
                    ></v-text-field>
                  </v-col>
                   <v-col
                   cols="12"
                    sm="6"
                    md="12">
                    <label>Address</label>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.brgy"
                      label="Brgy/Street"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.town"
                      label="Town"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.province"
                      label="Province"
                    ></v-text-field>
                  </v-col>
                  <v-col
                   cols="12"
                    sm="6"
                    md="12">
                    <label>Guardian</label>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.parent_last"
                      label="Last Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.parent_first"
                      label="First Name"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="6"
                    md="4"
                  >
                    <v-text-field
                      v-model="editedItem.parent_mid"
                      label="Middle Initial"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog
        v-model="subjDialog"
        max-width="500px"
        >
        <v-card>
          <v-container>
           <div v-for="(payloads, index) in payload" :key="index">
             <v-row>
               
                  <label>Course {{(index + 1)}}</label>
                   <v-col
                    cols="12"
                    sm="6"
                    md="6"
                    >
                      <v-text-field v-model="payloads.course_code" :label="'Course Code '"></v-text-field>
                      <v-text-field v-model="payloads.course" :label="'Course '"></v-text-field>
                   </v-col>
                    <v-col
                    cols="12"
                    sm="6"
                    md="6"
                    >
                      <v-text-field v-model="payloads.unit" :label="'Unit'"></v-text-field>
                      <v-text-field v-model="payloads.school_year" :label="'School Year'"></v-text-field>
                  </v-col>
              </v-row>
          </div>
            <v-row>
            <v-col cols="12" sm="6" md="6">
              <v-btn color="primary" @click="viewpayload()" :disabled="payload.length == 0">Submit</v-btn>
            </v-col>
            <v-col cols="12" sm="6" md="6">
              <v-btn color="primary" @click="addField()" :disabled="payload.length >= 10">Add Field</v-btn>
            </v-col>
          </v-row>
          </v-container>
        </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="enrollSubj(item)"
      >
      mdi-notebook
      </v-icon>
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="display()"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>
<script>
import axios from '../../../plugins/axios'
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
      subjDialog: false,
      headers: [
        { text: 'Last Name', value: 'last_name' },
        { text: 'First Name', value: 'first_name' },
        { text: 'Middle Initial', value: 'mid_name' },
        { text: 'Program', value: 'program' },
        { text: 'Town', value: 'town' },
        { text: 'Province', value: 'province' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      search: '',
      students: [],
      editedIndex: -1,
      editedItem: {
        last_name: '',
        first_name: '',
        mid_name: '',
        suffix: '',
        stud_no: '',
        program: '',
        dobirth: '',
        brgy:'',
        town:'',
        province:'',
        parent_last:'',
        parent_first:'',
        parent_mid:'',
      },
      defaultItem: {
         last_name: '',
        first_name: '',
        mid_name: '',
        suffix: '',
        stud_no: '',
        program: '',
        dobirth: '',
        brgy:'',
        town:'',
        province:'',
        parent_last:'',
        parent_first:'',
        parent_mid:'',
        protein: 0,
      },
      
      payload: []
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Student' : 'Edit Student'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      subjDialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    // created () {
    //   this.initialize()
    //   this.display
    // },
    mounted (){
      this.display()
    },

    methods: {
      

      editItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.students.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
        this.payload = []
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        axios.post('add-student', this.editedItem).then(res => {
          console.log(res)
          window.alert('Student Added');
          this.dialog = false
        })
        // if (this.editedIndex > -1) {
        //   Object.assign(this.desserts[this.editedIndex], this.editedItem)
        // } else {
        //   this.desserts.push(this.editedItem)
        // }
        // this.close()
      },
      display() {
        axios.get('get-student').then(res => {
          console.log(res)
          this.students = res.data
        })
      },
      enrollSubj(){
        this.subjDialog = true
      },
      addField() {
        this.payload.push({
        course_code: '',
        course: '',
        unit: '',
        school_year: '',
      })
      },
      viewpayload(){
        console.log(this.payload)
      }
    },
  }
</script>