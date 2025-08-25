#   Date of Refining: Sat-14-Sept-2024


#   What was Done:

##  Finished Login and Library Systen
##  Increased number of charts and how charts are selected.
##  Added Theme-Changing button
##  Polished UI

##  Stored Admin details in a file. These details can be updated, but no new admin can enter. Only after logging in can and admin update their details.

##  Some Notes

1.  Made heavy use of Sessions.
2.  Ensured that pages that should only be gotten via POST are gotten via POST.



#   Date: Tuesday 17th June, 2025


Revamped a lot of the content.


##  Things Learnt

If you have a button in a form, by default, when it is clicked, it submits the POST or GET request.
To stop this, you can either register a click event, and pass the event object as an argument so that in
the function you call `e.preventDefault`, or, in the case that you cannot register an event, e.g. registering
the onclick function inline in the html, just add the button's property, `type='button'`. This is opposed to
a button that submits which is of `type='submit'`. With the former, the button indeed acts like a normal button,
not submitting a POST request.

##  Conclusion

Here, I properly finished the project. It now works without errors and looks better.
It remains, though, that the details are 'admin`.

Even implemented registering an account and proper login. Though I didn't implement databases and password encryption, I did
implement sanitizing input from users.