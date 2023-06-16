<template>
  <v-card color="basil">
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
                    sm="3"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.stud_no"
                      label="Student_no"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="3"
                    md="3"
                  >
                      <v-select
                        v-model="editedItem.program"
                        :items="programs"
                        label="Standard"
                      ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="3"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.dobirth"
                      label="Date of Birth"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    sm="3"
                    md="3"
                  >
                    <v-text-field
                      v-model="editedItem.sex"
                      label="Sex"
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

    
    <v-tabs
      v-model="tab"
      background-color="transparent"
      color="basil"
      grow
    >
     
      <v-tab
        v-for="item in items"
        :key="item"
      >
        {{ item }}
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item
      >
        <v-card
          color="basil"
          flat
        >
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="ed"
              sort-by="calories"
              class="elevation-1"
              :search="search"
            >
              <template v-slot:top>
                <v-toolbar
                  flat
                >
                  <v-text-field
                  append-icon="mdi-magnify"
                  v-model="search"
                  flat
                  ></v-text-field>
                  <v-spacer></v-spacer>
                          
                        </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                <!-- <v-icon
                  small
                  class="mr-2"
                  @click="enrollSubj(item)"
                >
                mdi-notebook
                </v-icon> -->
                <v-btn
                    small
                    class="mr-2"
                     @click="enrollSubj(item)"
                      color="transparent"
                    elevation="0"
                  >
                    <!-- ADd  -->
                    <img :src="notebook" alt="NoteBook Icon"  width="15px" height="15px">
                  </v-btn>
                  <v-btn
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="transparent"
                    elevation="0"
                  >
                    <!-- Edit -->
                    <img :src="pencil" alt="Pencil Icon" width="15px" height="15px">
                  </v-btn>
                 <!-- <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
                >
                  mdi-eye
                </v-icon> -->
                 <v-btn
                    small
                    class="mr-2"
                   @click="showItem(item)"
                  color="transparent"
                    elevation="0"
                  >
                     <img :src="eye" alt="Eye Icon"  width="15px" height="15px">
                  </v-btn>
              
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
            
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item
      >
        <v-card
          color="basil"
          flat
        >
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="it"
              sort-by="calories"
              class="elevation-1"
              :search="search"
            >
              <template v-slot:top>
                <v-toolbar
                  flat
                >
                  <v-text-field
                  append-icon="mdi-magnify"
                  v-model="search"
                  flat
                  ></v-text-field>
                  <v-spacer></v-spacer>
                          
                        </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                 <v-btn
                    small
                    class="mr-2"
                     @click="enrollSubj(item)"
                      color="transparent"
                    elevation="0"
                  >
                    <!-- ADd  -->
                    <img :src="notebook" alt="NoteBook Icon"  width="15px" height="15px">
                  </v-btn>
                  <v-btn
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="transparent"
                    elevation="0"
                  >
                    <!-- Edit -->
                    <img :src="pencil" alt="Pencil Icon"  width="15px" height="15px">
                  </v-btn>
                 <!-- <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
                >
                  mdi-eye
                </v-icon> -->
                 <v-btn
                    small
                    class="mr-2"
                   @click="showItem(item)"
                  color="transparent"
                    elevation="0"
                  >
                     <img :src="eye" alt="Eye Icon"  width="15px" height="15px">
                  </v-btn>
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
            
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item
      >
         <v-card
          color="basil"
          flat
        >
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="crim"
              sort-by="calories"
              class="elevation-1"
              :search="search"
            >
              <template v-slot:top>
                <v-toolbar
                  flat
                >
                  <v-text-field
                  append-icon="mdi-magnify"
                  v-model="search"
                  flat
                  ></v-text-field>
                  <v-spacer></v-spacer>
                          
                        </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                 <v-btn
                    small
                    class="mr-2"
                     @click="enrollSubj(item)"
                      color="transparent"
                    elevation="0"
                  >
                    <!-- ADd  -->
                    <img :src="notebook" alt="NoteBook Icon"  width="15px" height="15px">
                  </v-btn>
                  <v-btn
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="transparent"
                    elevation="0"
                  >
                    <!-- Edit -->
                    <img :src="pencil" alt="Pencil Icon"  width="15px" height="15px">
                  </v-btn>
                 <!-- <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
                >
                  mdi-eye
                </v-icon> -->
                 <v-btn
                    small
                    class="mr-2"
                   @click="showItem(item)"
                  color="transparent"
                    elevation="0"
                  >
                     <img :src="eye" alt="Eye Icon"  width="15px" height="15px">
                  </v-btn>
              
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
            
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item
      >
          <v-card
          color="basil"
          flat
        >
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="hm"
              sort-by="calories"
              class="elevation-1"
              :search="search"
            >
       
              <template v-slot:top>
                <v-toolbar
                  flat
                >
                  <v-text-field
                  append-icon="mdi-magnify"
                  v-model="search"
                  flat
                  ></v-text-field>
                  <v-spacer></v-spacer>
                          
                        </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                 <v-btn
                    small
                    class="mr-2"
                     @click="enrollSubj(item)"
                      color="transparent"
                    elevation="0"
                  >
                    <!-- ADd  -->
                    <img :src="notebook" alt="NoteBook Icon"  width="15px" height="15px">
                  </v-btn>
                  <v-btn
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="transparent"
                    elevation="0"
                  >
                    <!-- Edit -->
                    <img :src="pencil" alt="Pencil Icon"  width="15px" height="15px">
                  </v-btn>
                 <!-- <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
                >
                  mdi-eye
                </v-icon> -->
                 <v-btn
                    small
                    class="mr-2"
                   @click="showItem(item)"
                  color="transparent"
                    elevation="0"
                  >
                     <img :src="eye" alt="Eye Icon"  width="15px" height="15px">
                  </v-btn>
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
            
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item
      >
          <v-card
          color="basil"
          flat
        >
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="cs"
              sort-by="calories"
              class="elevation-1"
              :search="search"
            >
              <template v-slot:top>
                <v-toolbar
                  flat
                >
                  <v-text-field
                  append-icon="mdi-magnify"
                  v-model="search"
                  flat
                  ></v-text-field>
                  <v-spacer></v-spacer>
                          
                        </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                 <v-btn
                    small
                    class="mr-2"
                     @click="enrollSubj(item)"
                      color="transparent"
                    elevation="0"
                  >
                    <!-- ADd  -->
                    <img :src="notebook" alt="NoteBook Icon"  width="15px" height="15px">
                  </v-btn>
                  <v-btn
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    color="transparent"
                    elevation="0"
                  >
                    <!-- Edit -->
                    <img :src="pencil" alt="Pencil Icon"  width="15px" height="15px">
                  </v-btn>
                 <!-- <v-icon
                  small
                  class="mr-2"
                  @click="showItem(item)"
                >
                  mdi-eye
                </v-icon> -->
                 <v-btn
                    small
                    class="mr-2"
                   @click="showItem(item)"
                  color="transparent"
                    elevation="0"
                  >
                     <img :src="eye" alt="Eye Icon"  width="15px" height="15px">
                  </v-btn>
              </template>
              <template v-slot:no-data>
                No Records Found
              </template>
            </v-data-table>
            
          </v-card-text>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
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
        max-width="700px"
        >
        <v-card>
          <v-card-title>
          Add Enrolled Subject

          </v-card-title>
          <v-text-field v-model="editedItem.id" style="display:none"></v-text-field>

          <v-container>
           <div v-for="(payloads, index) in payload" :key="index">
           
              <label>Course {{(index + 1)}}</label>

                    <v-text-field v-model="payloads.course_code" :label="'Course Code'"></v-text-field>
                    <v-text-field v-model="payloads.course" :label="'Course'"></v-text-field>
                    <v-text-field type="number" v-model="payloads.unit" :label="'Unit'"></v-text-field>
                    <v-text-field v-model="payloads.school_year" :label="'School Year'"></v-text-field>
                    <v-btn @click="removeField(index)" class="mb-2">
                      <v-icon>mdi-minus</v-icon>
                    </v-btn>
          </div>
              <v-btn text elevation="0" @click="addField()" :disabled="payload.length >= 10"> 
                <v-icon dark>
                  mdi-plus
                </v-icon>
              </v-btn>
              <v-btn color="primary" @click="submitSubject()" :disabled="payload.length == 0">Submit</v-btn>
          </v-container>
        </v-card>
        </v-dialog>
        <v-dialog
        v-model="dialogShow"
        width="750px"
        >
          <!-- {{ this.editedItem }} -->

          <v-card
          
            width="800px">
            <v-row>
              <v-col
                sm="6"
                md="6"
              >
              <h3 class="ma-2 pa-2">Name : {{ this.editedItem.first_name + ' ' + this.editedItem.last_name}} </h3>

              </v-col>
              <v-col
                sm="6"
                md="6"
              >
              <h3 class="ma-2 pa-2">Program : {{ this.editedItem.program }}</h3>
              </v-col>
            </v-row>
            <v-data-table
              :headers="subjectss"
              :items="editedItem.record"
              sort-by="calories"
              class="elevation-1"
              :pagination="false"
              :search="search"
              :hide-default-footer="true"
            ></v-data-table>
          </v-card>
        </v-dialog>
        <v-dialog
        v-model="listDialog"
        width="400px"
        >
          <v-card>
            <v-card-title>Generate Student List</v-card-title>
            <v-select
              :items="itemed"
              filled
              label="Select Year"
              class="pa-2"
              v-model="payload.year"
            ></v-select>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" class="pa-2" @click="exportList()">
                Generate
              </v-btn>
            </v-card-actions>
          
          </v-card>
        </v-dialog>
        <v-card-actions>
          <v-spacer></v-spacer>
            <v-btn color="primary" class="pa-2" @click="listDialog = true">
              Generate Student List
            </v-btn>
        </v-card-actions>
  </v-card>
</template>
// <script>
//   export default {
//     data () {
//       return {
//         tab: null,
//         items: [
//           'BEED', 'BSIT', 'BSCRIM', 'BSHM', 'BSCS',
//         ],
//         // text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
//       }
//     },
//   }
// </script>

<script>
import axios from '../../../plugins/axios'
import pencil from '../../../assets/pencil.png'
import notebook from '../../../assets/notebook.png'
import eye from '../../../assets/eye.png'
  export default {
    data: () => ({
      pencil,
      notebook,
      eye,
       tab: null,
      items: [
        'BEED', 'BSIT', 'BSCRIM', 'BSHM', 'BSCS',
      ],
      itemed: ['2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034', '2035', '2036', '2037', '2038', '2039', '2040', '2041', '2042', '2043', '2044', '2045', '2046', '2047', '2048', '2049', '2050'],
      payload: {
        year: ''
      },
      programs : ['BSIT', 'BSCRIM', 'BEED', 'BSHM', 'BSCS' ],
      dialog: false,
      dialogShow: false,
      dialogDelete: false,
      listDialog: false,
      subjDialog: false,
      headers: [
        { text: 'No.', value: 'id' },
        { text: 'Last Name', value: 'last_name' },
        { text: 'First Name', value: 'first_name' },
        { text: 'Middle Initial', value: 'mid_name' },
        { text: 'Student No.', value: 'stud_no' },
        { text: 'Birthday', value: 'dobirth' },
        { text: 'Barangay', value: 'brgy' },
        { text: 'Town', value: 'town' },
        { text: 'Province', value: 'province' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      subjectss: [
        { text: 'Descriptive Title', value: 'course' },
        { text: 'Unit', value: 'unit' },
      ],
      search: '',
      students: [],
      it : [],
      cs : [],
      crim : [],
      ed : [],
      hm : [],
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
        record : []
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
      selectedItemId: null,
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
      // this.display()
      this.displayEd()
      this.displayIT()
      this.displayCRIM()
      this.displayHM()
      this.displayCS()
    },

    methods: {
      exportList() {
        axios.post('/exportList', { year: this.payload.year }, {
            responseType: 'blob', // Set the response type to blob
        }).then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data])); // Create a temporary URL for the blob data
            const link = document.createElement('a'); // Create a new anchor element
            link.href = url; // Set the href attribute to the temporary URL
            link.setAttribute('download', 'studentInsurance.pdf'); // Set the download attribute to the file name
            document.body.appendChild(link); // Append the anchor element to the DOM
            link.click(); // Simulate a click event to trigger the download
            link.remove(); // Remove the anchor element from the DOM
          this.enrollmentDialog = false
        }).catch(error => {
            console.log(error); // Handle any errors
        });
    },

      editItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      showItem (item) {
        this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogShow = true
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

        if (this.editedIndex > -1) {
            axios.post('edit-student/' + this.editedItem.id, this.editedItem).then(res => {
            console.log(res)
            window.alert('Student Updated');
            this.dialog = false
            this.display()
        })
        } else {
            axios.post('add-student', this.editedItem).then(res => {
            console.log(res)
            window.alert('Student Added');
            this.dialog = false
            this.display()
        })
        }
      
      },
      display() {
        axios.get('get-student').then(res => {
          console.log(res)
          this.students = res.data
        })
      },
      displayEd() {
        axios.get('get-ED').then(res => {
          console.log(res)
          this.ed = res.data
        })
      },
      displayIT() {
        axios.get('get-IT').then(res => {
          console.log(res)
          this.it = res.data
        })
      },
      displayCRIM() {
        axios.get('get-CRIM').then(res => {
          console.log(res)
          this.crim = res.data
        })
      },
      displayHM() {
        axios.get('get-HM').then(res => {
          console.log(res)
          this.hm = res.data
        })
      },
      displayCS() {
        axios.get('get-CS').then(res => {
          console.log(res)
          this.cs = res.data
        })
      },
      enrollSubj(item){
         this.editedIndex = this.students.indexOf(item)
        this.editedItem = Object.assign({}, item)
        // this.load = item
        this.subjDialog = true
        console.log(this.editedItem.id)
      },
      addField() {
        this.payload.push({
        course_code: '',
        course: '',
        unit: '',
        school_year: '',
      })
      },
       removeField(index) {
      this.payload.splice(index, 1)
      },
      submitSubject() {
        const payloads = this.payload.map((item) => {
          return {
            student_id: this.editedItem.id,
            course_code: item.course_code,
            course: item.course,
            unit: item.unit,
            school_year: item.school_year
          };
        });

        console.log(payloads);

        axios.post('insert-subjects', payloads).then (res => {
          console.log(res.data, ' Response ')
          this.subjDialog = false
        })
      
      },

      
    },
  }
</script>