#include <iostream>
#include <fstream>
#include <string>
#include "manager.h"

using namespace std;

int main()
{

    Column column[20];
    Element element;

    cout << "\nTable =";
    cin >> element.table;
    cout << "\nModel =";
    cin >> element.model;
    cout << "\nArabic Single =";
    cin >> element.arabicSingle;
    cout << "\nArabic Name =";
    cin >> element.arabic;
    cout << "\nColumn Counts =";
    cin >> element.columnCount;

    for (int i = 0; i < element.columnCount; i++)
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

        cout << "Enter IF Search Y/N = ";
        cin >> column[i].search;
    }


    create_controller(element,column);
    create_model(element,column);
    create_table(element,column);
    create_permissions(element,column);
    create_route_api(element,column);

    return 0;
}
