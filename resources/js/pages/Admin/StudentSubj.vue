<template>
  <div>
    <v-data-table :headers="headers" :items="studentRows" />
  </div>
</template>

<script>
import axios from '../../plugins/axios'
export default {
  data() {
    return {
      students: [],
      headers: [
        { text: "Student No", value: "stud_no" },
        { text: "Last Name", value: "last_name" },
        { text: "First Name", value: "first_name" },
        { text: "Middle Name", value: "mid_name" },
        { text: "Extension on the Name", value: "suffix" },
        { text: "Sex", value: "sex" },
        
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
    // for (let i = 0; i < this.students.length; i++) {
    //   const record = this.students[i].record;
    //   for (let j = 0; j < record.length; j++) {
    //     const subject = record[j].course;
    //     subjects.add(subject);
    //   }
    // }

    // Generate headers array with one column per subject
    const maxSubjects = this.getMaxSubjects();
    // Slice the unique subjects array to include only up to maxSubjects, then map it to an array of header objects
    const subjectHeaders = Array.from(subjects).slice(0, maxSubjects).map((subject, index) => ({
      text: subject,
      value: `subject_${index + 1}`
    },
    {
      text: unit,
      value: `unit_${index + 1}`
    }
    
    ));
    // Append the subject headers to the existing headers array
    this.headers = [...this.headers, ...subjectHeaders];
  },

  methods: {
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
            const subject = record[j].course;
            const unit = record[j].unit;
            subjects.add(subject, unit);
          }
        }

        // Generate headers array with one column per subject
        const maxSubjects = this.getMaxSubjects();
        const subjectHeaders = Array.from(subjects).slice(0, maxSubjects).map((subject, index) => (
          { text: `Course ${index + 1}`, value: `subject_${index + 1}`}
          // { text: `Unit ${index + 1}`, value: `unit_${index + 1}`}
          ));

        
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
        for (let j = 0; j < student.record.length; j++) {
          const subject = student.record[j];
          row[`subject_${j+1}`] = subject.course;
        }
        rows.push(row);
      }
      return rows;
    }
  }
};
</script>
