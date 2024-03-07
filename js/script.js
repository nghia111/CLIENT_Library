$(document).ready(function () {
  $("#frmRegForm").validate({
    rules: {
      firstname: {
        required: true,
        minlength: 2,
      },
      lastname: {
        required: true,
        minlength: 2,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
      repassword: {
        required: true,
        equalTo: "#password",
      },
    },
    message: {
      firstname: {
        required: "Please enter first name",
        minlength: "First name must be at least 2 characters",
      },
      lastname: {
        required: "Please enter last name",
        minlength: "Last name must be at least 2 characters",
      },
      email: {
        required: "Please enter email",
        email: "Please enter valid email",
      },
      password: {
        required: "Please enter password",
      },
      repassword: {
        required: "Retype-password is required",
        equalTo: "Password not matching",
      },
    },
  });
});


// Initialization for ES Users
import { Dropdown, Collapse, initMDB } from "mdb-ui-kit";

initMDB({ Dropdown, Collapse });