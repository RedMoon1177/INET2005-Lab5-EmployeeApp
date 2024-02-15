function validateSearchForm ()
{
    if(document.forms['myForm'].txtSearch.value.length == 0)
    {
        document.forms['myForm'].txtSearch.style.borderColor = "red";

        var txtWarning = document.getElementById('txtWarning');
        txtWarning.style.color = "red";
        txtWarning.style.fontStyle = "bold";
        txtWarning.innerHTML = "Please type something to search!";

        return false;
    } else
    {
        return true;
    }
}


/*
* Validate the data on HTML forms for employee INSERTION or UPDATE
* * The birthdate and hire dates must be in YYYY-MM-DD number format.
* * First and last names must begin with a capital letter followed by one or more lower case letters.
* * The gender can be only a single character to accommodate various gender types.
* (Ex: M for male, F for female, T for transgender, and so on.)
* * Appropriate error messages must be displayed in areas next to the erroneous fields in the form and not as pop-up boxes.
*/

/**
 * Function 1: myRegExpName(myName)
 *           check name format
 * */
function myRegExpName(myName)
{

    const regexp = /^[A-Z][a-z]*$/;
    var result = myName.match(regexp);
    if (result == null) {
        return false;
    }
    return true;
}

/*
* Function 2: Raise error warning for user input
* parameters:
*    + field: <input> element
*    + txtWarningElement: <span> html element
*    + warningMsg: error message that will be displayed in red color
*/
function raiseWarningTxt(field, txtWarningElement, warningMsg)
{
    field.style.borderColor = "red";
    txtWarningElement.style.color = "red";
    txtWarningElement.style.fontStyle = "bold";
    txtWarningElement.innerHTML = warningMsg;
}

/*
* Function 3: Reset input field
* Reset red border to normal and reset text warning to empty.
*/
function resetField(field, txtWarningElement)
{
    field.style.borderColor = "unset";
    txtWarningElement.innerHTML = "";
}

/**
 * Function 4: check a field is left empty or not
 *             __ return true: empty
 * */
function isEmptyField(field, txtWarningElement)
{
    var flag = false;

    if (field.value.length == 0)
    {
        raiseWarningTxt(field, txtWarningElement, "Please fill out the field!");
        flag = true;
    } else
    {
        resetField(field, txtWarningElement);
    }

    return flag;
}

/**
 * Function 5: Validate Dates in general
 *            parameters: field input and <span> html element to raise error
 *            __ return TRUE: valid
 * */
function validateDates(field, txtWarningElement)
{
    var flag = false;

    var myDate = field.value;

    // check if the length of date (YYYY-MM-DD) = 10 or not
    // for example: "2023-12-3" : invalid => "2023-12-03" : valid

    if(field.value.length == 10)
    {
        if (myDate[4] == '-' && myDate[7] == '-')
        {
            var myArray = myDate.split('-');
            var year = parseInt(myArray[0]);
            var month = parseInt(myArray[1]);
            var day = parseInt(myArray[2]);

            if (isNaN(year) || isNaN(month) || isNaN(day)) {

                raiseWarningTxt(field, txtWarningElement, "Invalid Dates!");

            } else {
                if (day <= 0 || day >= 32) {

                    raiseWarningTxt(field, txtWarningElement, "Invalid Day! Should be from 1 to 31!");

                } else if (year <= 0 || year >= 10000) {

                    raiseWarningTxt(field, txtWarningElement, "Invalid Year! Should be from 1000 to 9999!");

                } else if (month <= 0 || month >= 13) {

                    raiseWarningTxt(field, txtWarningElement,"Invalid Month! Should be from 1 to 12!");

                } else {

                    resetField(field, txtWarningElement);

                    flag = true;
                }
            }

        } else {

            raiseWarningTxt(field, txtWarningElement,"Must be in YYYY-MM-DD format!");
        }
    } else {

        raiseWarningTxt(field, txtWarningElement,"Must be in YYYY-MM-DD format!");
    }


    return flag;
}

/**
 * Function 6: validate genders in general
 *            parameters: field input and <span> html element to raise error
 *            __ return TRUE: valid
 * */
function validateGender(field, txtWarningElement)
{
    var flag = false;
    var genderCode = ["M", "F", "T", "O"];

    var input = field.value;

    for (var i=0; i < genderCode.length; i++)
    {
        if (input.localeCompare(genderCode[i]) != 0)
        {
            raiseWarningTxt(field, txtWarningElement,"Accepted: 'M':male; 'F':Female; 'T':Transgender; 'O':Others");
        } else
        {
            resetField(field, txtWarningElement);

            flag = true;
            break;
        }
    }

    return flag;
}

/**
 * Function 7: validate names in general
 *            parameters: field input and <span> html element to raise error
 *            __ return TRUE: valid
 * */
function validateNames(field, txtWarningElement)
{
    var flag = false;

    var result = myRegExpName(field.value);

    if(!result)
    {
        raiseWarningTxt(field, txtWarningElement,"Start with a capital letter followed by lower-case ones!");
    } else
    {
        resetField(field, txtWarningElement);

        flag = true;
    }

    return flag;
}





///////////////////////////////////////////////////////////////////////
// VALIDATE INSERTION FORM
function validateDataEntry()
{
    var flag1 = false;
    var flag2 = false;
    var flag3 = false;
    var flag4 = false;

    // // get all the text warning HTML elements
    var txtWarningBD = document.getElementById('txtWarningBD');
    var txtWarningFN = document.getElementById('txtWarningFN');
    var txtWarningLN = document.getElementById('txtWarningLN');
    var txtWarningHD = document.getElementById('txtWarningHD');

    // // check birthdate
    if(!isEmptyField(document.forms['myForm'].birth_date, txtWarningBD))
    {
        flag1 = true;
    }

    // // check first name
    if(!isEmptyField(document.forms['myForm'].first_name, txtWarningFN))
    {
        if(validateNames(document.forms['myForm'].first_name, txtWarningFN))
        {
            flag2 = true;
        }
    }

    // check last name
    if(!isEmptyField(document.forms['myForm'].last_name, txtWarningLN))
    {
        if(validateNames(document.forms['myForm'].last_name, txtWarningLN))
        {
            flag3 = true;
        }
    }

    // check hire date
    if(!isEmptyField(document.forms['myForm'].hire_date, txtWarningHD))
    {
        flag4 = true;
    }

    return flag1 && flag2 && flag3 && flag4;
}





///////////////////////////////////////////////////////////////////////
// VALIDATE UPDATE FORM
function validateDataUpdate() {
    var flag1 = false;
    var flag2 = false;
    var flag3 = false;
    var flag4 = false;
    var flag5 = false;

    // get all the text warning HTML elements
    var txtWarningBD = document.getElementById('txtWarningBD');
    var txtWarningFN = document.getElementById('txtWarningFN');
    var txtWarningLN = document.getElementById('txtWarningLN');
    var txtWarningGD = document.getElementById('txtWarningGD');
    var txtWarningHD = document.getElementById('txtWarningHD');

    // check birthdate
    if (!isEmptyField(document.forms['myForm'].birth_date, txtWarningBD))
    {
        if (validateDates(document.forms['myForm'].birth_date, txtWarningBD))
        {
            flag1 = true;
        }
    }

    // check first name
    if (!isEmptyField(document.forms['myForm'].first_name, txtWarningFN))
    {
        if (validateNames(document.forms['myForm'].first_name, txtWarningFN))
        {
            flag2 = true;
        }
    }

    // check last name
    if (!isEmptyField(document.forms['myForm'].last_name, txtWarningLN))
    {
        if (validateNames(document.forms['myForm'].last_name, txtWarningLN))
        {
            flag3 = true;
        }
    }

    // check gender
    if(!isEmptyField(document.forms['myForm'].gender, txtWarningGD))
    {
        if(validateGender(document.forms['myForm'].gender, txtWarningGD))
        {
            flag4 = true;
        }
    }

    // check hire date
    if (!isEmptyField(document.forms['myForm'].hire_date, txtWarningHD))
    {
        if (validateDates(document.forms['myForm'].hire_date, txtWarningHD))
        {
            flag5 = true;

        }
    }

    return flag1 && flag2 && flag3 && flag4 && flag5;
}