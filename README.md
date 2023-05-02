# databases-pr
CS 4750 Group Project

TODO:

1. Planner Page (Henry)
  a. Separate planner and schedule in planner page
  b. sort years in planner dropdown
  c. add button to remove from planner/schedule on planner page
2. Triggers/Logging (Matt?)
  a. fix triggers to not break adding/removing to planner/schedule and test that they add logs to log table
3. Requirements Page (Alex?)
  a. Add a table for second major requirements
  b. add more data (choose one major to have at least one or two courses fulfill each requirement so we can demo!)
4. (Optional) Styling (Rebecca?)
  a. Add coloring/UVA styling to make website look better
7. (Optional) GCP Hosting (for extra credit and to fix DB-level security)


Requirements:
(done )1. Use >= 10 (normalized) tables
(done) 2. Fulfills our proposed project (retrieves classes, adds to planner, updates planner/major info, remove from planner, filter courses)
(partially complete) 3. Dynamic behaviors: searching/filtering, dropdown filters on planner for semester/year, (requirements updating after fulfilling courses added ??)
(done) 4. Functionalities
  a. Retrieve (course info, name, major info, requirements)
  b. Add (to planner, major info)
  c. Update (major info)
  d. Delete (planner info)
  e. Search (courses)
  f. Filter (courses + planner)
(done) 6. Support multiple users (no conflicted operations!)
(done) 7. Allow Returning users (Login/Logout, Register, data fetched for planner and requirements is per user)
8. Security
  (done) a. App level security (password hashing, redirection, HTML special character handling)
  (incomplete!) b. DB level security: NEED TO FIX TRIGGERS
