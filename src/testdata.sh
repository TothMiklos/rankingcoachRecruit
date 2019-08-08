curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name1'\''","email": "'\''email1@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name2'\''","email": "'\''email2@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name3'\''","email": "'\''email3@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name4'\''","email": "'\''email4@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name5'\''","email": "'\''email5@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/




curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 1,"service_id": 1,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 1,"service_id": 2,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 1,"service_id": 3,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 1,"service_id": 4,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 2,"service_id": 1,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"user_id": 3,"service_id": 3,"start_date": "'\''01-01-2018'\''","end_date": "'\''01-01-2020'\''"}' $1/subscription/create/