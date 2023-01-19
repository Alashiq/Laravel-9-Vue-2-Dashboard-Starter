#include <iostream>
#include <fstream>
#include <string>
#include "manager.h"

using namespace std;

int main()
{



    string tableName;
    string modelName;
    int columnCount;
    Column column[10];
    Column cc;

    cout << "Enter Your Table =";
    cin >> tableName;
    cout << "Enter Your Model =";
    cin >> modelName;
    cout << "Enter Column Counts =";
    cin >> columnCount;

    for (int i = 0; i < columnCount; i++)
    {
        cout << "Enter Column " << i + 1 << " Name = ";
        cin >> column[i].name;
        cout << "Enter Column " << i + 1 << " Type Number ";
        cout << "String 1 - Integer 2 - Json 3 =";
        cin >> column[i].type;
        if (column[i].type == "1")
            column[i].type = "string";
        else if (column[i].type == "2")
            column[i].type = "integer";
        else if (column[i].type == "3")
            column[i].type = "json";
    }

    create_controller(tableName, modelName);
    create_model(tableName, modelName,column,columnCount);

    return 0;
}
