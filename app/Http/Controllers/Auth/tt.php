1. SELECT p.ID,p.Fname,p.Lname 
      FROM person p  JOIN works w 
      ON p.ID=w.ID
      JOIN branch b  
      ON b.branchID=w.branchID 
      WHERE (p.ID=w.ID AND b.state="Nj");
2. SELECT p.ID,p.Lname 
        FROM person p 
        JOIN works
        ON p.ID=w.ID
        JOIN branch
        branch b  ON b.branchID=w.branchID 
        WHERE (p.ID=w.ID AND b.bankname="TD");
3. SELECT p.ID,p.Fname FROM person p 
        JOIN works w 
        WHERE (p.ID=w.ID);
4. SELECT p.ID,p.Fname FROM person p 
        JOIN works
        ON w.ID=p.ID
        WHERE (p.ID NOT IN (SELECT b.branchID WHERE b.branchID=w.branchID);

5. SELECT p.ID,p.Lname
        FROM person p 
        JOIN works
        WHERE (p.ID IN (SELECT oversees.managerID FROM oversees));
6. SELECT p.ID,b.branchID 
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch b  
        WHERE (p.ID=w.ID AND p.ID NOT IN (SELECT oversees.managerID FROM oversees));
7. SELECT p.ID,p.Fname,p.Lname
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
        WHERE (p.ID=w.ID AND p.ID NOT IN (SELECT oversees.managerID FROM oversees));

8. SELECT p.Lname,b.branchID
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
        WHERE (p.ID=w.ID AND p.ID IN (SELECT oversees.managerID FROM oversees)); 
9. SELECT p.ID,p.Fname,p.Lname,w.salary,b.branchID 
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
        WHERE (p.ID=w.ID AND p.ID=oversees.managerID AND b.state="TD");
10. SELECT p.ID,p.Lname 
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
        WHERE (p.ID=w.ID AND b.bankname='TD' AND (w.salary*12)<50000);
11. SELECT p.ID,p.Lname 
        FROM person p 
        JOIN branch
        WHERE (b.branchID IN (SELECT top 1 branchID FROM branch b  order by b.investments DESC) );
12. SELECT p.ID,p.Lname,w.salary
        FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
        WHERE (p.ID=w.ID IN (SELECT oversees.managerID FROM oversees));
13.	SELECT b.bankname FROM branch b  
        WHERE (b.state IN (SELECT b.state FROM branch b  WHERE (b.bankname='TD' )))
14.	select SUM(w.salary)salary ,b.branchID into #salary 
        from branch
        Join works w WHERE (b.branchID=w.branchID )
        GROUP by b.branchID
        select b.bankname from branch,#salary where (b.branchID=#salary.branchID)
        order by #salary.salary desc
15.	 SELECT MIN(countperson p s),branchID
        FROM (SELECT branchID,COUNT(p.ID) countperson p s 
        FROM branch
        JOIN person p 
        GROUP BY branchID) GROUP by branchID
16.	 SELECT COUNT(*) AS NumberOfEmployees,
       AVG(w.salary) AS AverageSalary,
       (SELECT COUNT(*)
          FROM person p ,works
         WHERE (w.salary < (SELECT AVG(w.salary) FROM works))
       ) AS NumberOfEmployeesPaidSubAverageSalary
  FROM person p ,branch,works w where (w.branchID=b.branchID and p.ID=w.ID
  and b.bankname='TD');
17.	UPDATE branch b  SET b.bankname='NBT' WHERE (b.bankname='Alliance');
18.	UPDATE works w SET w.salary=w.salary*0.95 WHERE (w.salary>50000);
19.	SELECT p.ID,p.Lname 
      FROM person p 
        JOIN works
        ON w.ID=p.ID
        JOIN branch
        ON b.branchID=w.branchID
       WHERE (COUNT(b.state)> AND COUNT(w.ID)>2);
20.	UPDATE works w SET w.salary=w.salary*1.05 
    WHERE (w.ID NOT IN (SELECT oversees.managerID FROM oversees) AND b.bankname='TD');