<template>
  <div>
    <div>
      <v-data-table :headers="headers" :items="studentRows" />
    </div>
    <v-btn color="primary" class="pa-2" @click="enrollmentDialog = true">
      Generate Enrollment List
    </v-btn>
    <v-btn color="primary" class="pa-2" @click="enrollment2Dialog = true">
      Generate Enrollment List(By Program)
    </v-btn>
    
    <v-dialog
      v-model="enrollmentDialog"
      width="400px"
    >
      <v-card>
        <v-card-title>Generate Enrollment List</v-card-title>
         <v-select
          :items="items"
          filled
          label="Select Year"
          class="pa-2"
          v-model="payload.year"
        ></v-select>
        <v-card-actions>
          <v-spacer></v-spacer>
           <v-btn color="primary" class="pa-2" @click="exportEnroll()">
            Generate
          </v-btn>
        </v-card-actions>
       
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="enrollment2Dialog"
      width="400px"
    >
      <v-card>
        <v-card-title>Generate Enrollment List</v-card-title>
         <v-select
          :items="items"
          filled
          label="Select Year"
          class="pa-2"
          v-model="payload.year"
        ></v-select>
         <v-select
          :items="itemed"
          filled
          label="Select Program"
          class="pa-2"
          v-model="payload.program"
        ></v-select>
        <v-card-actions>
          <v-spacer></v-spacer>
           <v-btn color="primary" class="pa-2" @click="exportByProgram()">
            Generate
          </v-btn>
        </v-card-actions>
       
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from '../../plugins/axios'
export default {
  data() {
    return {
      items: ['2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032', '2033', '2034', '2035', '2036', '2037', '2038', '2039', '2040', '2041', '2042', '2043', '2044', '2045', '2046', '2047', '2048', '2049', '2050'],
      itemed :['BSIT', 'BSCRIM', 'BEED', 'BSHM', 'BSCS' ],
      detailDialog: false,
      enrollmentDialog: false,
      enrollment2Dialog: false,
      payload: {
        year: '',
        program: ''
      },
      students: [],
      headers: [
        { text: "Student No", value: "stud_no" },
        { text: "Last Name", value: "last_name" },
        { text: "First Name", value: "first_name" },
        { text: "Middle Name", value: "mid_name" },
        { text: "Extension on the Name", value: "suffix" },
        { text: "Sex", value: "sex" },
        { text: "Total Units", value: "total_units" }
     
      ]

    };
  },

  mounted () {
    this.display()
  },

  created() {
  // Get unique list of subjects from students data property
  const subjects = new Set();

  // Move this loop to the 'display' method to ensure that the students data is populated before creating headers
  for (let i = 0; i < this.students.length; i++) {
    const record = this.students[i].record;
    for (let j = 0; j < record.length; j++) {
      const subject = record[j].course_code;
      subjects.add(subject);
    }
  }

  // Generate headers array with one column per subject
  const maxSubjects = this.getMaxSubjects();
  // Slice the unique subjects array to include only up to maxSubjects, then map it to an array of header objects
  const subjectHeaders = Array.from(subjects).slice(0, maxSubjects).map((subject, index) => {
  const headerObj = {};
  headerObj[`subject_${index + 1}`] = subject;
  headerObj[`unit_${index + 1}`] = '';
  return headerObj;
});


  // Append the subject headers to the existing headers array
  this.headers = [...this.headers, ...subjectHeaders];
},



  methods: {

    exportEnroll() {
        axios.post('/export', { year: this.payload.year }, {
            responseType: 'blob', // Set the response type to blob
        }).then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data])); // Create a temporary URL for the blob data
            const link = document.createElement('a'); // Create a new anchor element
            link.href = url; // Set the href attribute to the temporary URL
            link.setAttribute('download', 'filename.pdf'); // Set the download attribute to the file name
            document.body.appendChild(link); // Append the anchor element to the DOM
            link.click(); // Simulate a click event to trigger the download
            link.remove(); // Remove the anchor element from the DOM
          this.enrollmentDialog = false
        }).catch(error => {
            console.log(error); // Handle any errors
        });
    },
    exportByProgram() {
        axios.post('/exportbyprogram', { year: this.payload.year, program : this.payload.program }, {
            responseType: 'blob', // Set the response type to blob
        }).then(response => {
            const url = window.URL.createObjectURL(new Blob([response.data])); // Create a temporary URL for the blob data
            const link = document.createElement('a'); // Create a new anchor element
            link.href = url; // Set the href attribute to the temporary URL
            link.setAttribute('download', 'filename.pdf'); // Set the download attribute to the file name
            document.body.appendChild(link); // Append the anchor element to the DOM
            link.click(); // Simulate a click event to trigger the download
            link.remove(); // Remove the anchor element from the DOM
          this.enrollmentDialog = false
        }).catch(error => {
            console.log(error); // Handle any errors
        });
    },
    display() {
      axios.get('display-subjects').then(response => {
        console.log(response.data);
        // Populate the students data property with the response data
        this.students = response.data;

        // Get unique list of subjects from students data property
        const subjects = new Set();
        for (let i = 0; i < this.students.length; i++) {
          const record = this.students[i].record;
         for (let j = 0; j < record.length; j++) {
            const subject = record[j].course_code;
            const unit = record[j].unit;
            subjects.add(subject);

          }
        }

        // Generate headers array with one column per subject
        const maxSubjects = this.getMaxSubjects();
        const subjectHeaders = [];
        for (let i = 0; i < maxSubjects; i++) {
          subjectHeaders.push({
            text: `Course Code ${i + 1}`,
            value: `subject_${i + 1}`
          });
          subjectHeaders.push({
            text: `Unit ${i + 1}`,
            value: `unit_${i + 1}`
          });
        }

        // Append the subject headers to the existing headers array
        this.headers = [...this.headers, ...subjectHeaders];
      }) 
    },

    getMaxSubjects() {
      let maxSubjects = 0;
      for (let i = 0; i < this.students.length; i++) {
        const student = this.students[i];
        if (student.record.length > maxSubjects) {
          maxSubjects = student.record.length;
        }
      }
      return maxSubjects;
    }
  },

  computed: {

  studentRows() {
    const rows = [];
    const numCols = this.headers.length;
    for (let i = 0; i < this.students.length; i++) {
      const student = this.students[i];
      const row = { stud_no: student.stud_no , last_name: student.last_name, first_name: student.first_name, mid_name: student.mid_name, suffix: student.suffix, sex: student.sex };
       let totalUnits = 0;
      for (let j = 1; j <= student.record.length; j++) {
  const subject = student.record[j-1];
  row[`subject_${j}`] = subject.course_code;
  row[`unit_${j}`] = subject.unit;
  totalUnits += subject.unit;
}
  row['total_units'] = totalUnits;

      rows.push(row);
    }
    return rows;
  }
}

};
</script>
