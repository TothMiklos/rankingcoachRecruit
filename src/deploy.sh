#param1 = Webserver url
#param2 = DB host
#param3 = DB username
#param4 = DB password
#param5 = DB port
#param6 = DB socket

if [ $# -eq 6 ]
    then
        printf $1, > ./.conf
        printf $2, >> ./.conf
        printf $3, >> ./.conf
        printf $4, >> ./.conf
        printf $5, >> ./.conf
        printf $6 >> ./.conf
fi

if [ $# -eq 5 ]
    then
        printf $1, > ./.conf
        printf $2, >> ./.conf
        printf $3, >> ./.conf
        printf $4, >> ./.conf
        printf $5 >> ./.conf
fi

if [ $# -eq 4 ]
    then
        printf $1, > ./.conf
        printf $2, >> ./.conf
        printf $3, >> ./.conf
        printf $4 >> ./.conf
fi

if [ $# -eq 3 ]
    then
        printf $1, > ./.conf
        printf $2, >> ./.conf
        printf $3 >> ./.conf
fi

if [ $# -eq 2 ]
    then
        printf $1, > ./.conf
        printf $2 >> ./.conf
fi

if [ $# -eq 1 ]
    then
        printf $1 > ./.conf
fi

curl -i \
-H "Accept: application/json" \
-H "Content-Type:application/json" \
-X POST --data '{"name": "'\''name1'\''","email": "'\''email!@somewhere'\''","birth_date": "'\''01-01-1981'\''"}' $1/account/create/