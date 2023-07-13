<div align="center">
  
# Kodemason - Task

</div>

Please follow the task description. <br>

Make an efficient web software which finds out the top 10 users who have most topup at the previous day. Make a process that will run every day first hour automatically, and can also initiate the process manually. <be>

## Notes:
Use only three tables with below required fields along with the necessary fields
1. Users (required fields: name, email)
2. Topups (required fields: users_id, amount)
3. Top Topup Users (required fields: users_id, count): This table will hold maximum 10 records

For View make only one page, that will show the top topup users with search and in this page make a button that can initiate the process of finding the previous day's top topup users.


## Requirements :
1. Laravel version 8
2. Design Database
3. Maintain Coding Structure
4. Write Clean Code
5. Maintain Folder Structure
6. Use Database Queue Driver
7. Minimum User Records 500
8. Minimum Topup Records 200,000 /per day (need only 3 days worth of records)
9. Make blade template view for top users (show only 2 records per page)
10. Make a search field to search by user
11. Make a button that can initiate the top user finding process
12. For the design you can use bootstrap free AdminLTE template or whichever you like
13. No need for Authentication

