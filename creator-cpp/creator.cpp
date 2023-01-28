#include <iostream>
#include <fstream>
#include <string>
#include "manager.h"


using namespace std;

int main()
{

    Column column[20];
    Element element;

    cout << "\nModel =";
    cin >> element.model;

    cout << "\nModel with S =";
    cin >> element.models;

    cout << "\nTable =";
    cin >> element.table;

    cout << "\nSingle =";
    cin >> element.single;


    cout << "\nArabic Single =";
    cin >> element.arabicSingle;
    cout << "\nArabic Name =";
    cin >> element.arabic;
    cout << "\nColumn Counts =";
    cin >> element.columnCount;

        cout << "\nPage Id =";
    cin >> element.pageId;

    for (int i = 0; i < element.columnCount; i++)
    {
        cout << "Enter Column " << i + 1 << " Name = ";
        cin >> column[i].name;

        cout << "Arabic Column = ";
        cin >> column[i].arabic;

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

        cout << "Enter IF Show In List Y/N = ";
        cin >> column[i].showInList;

    }

    create_controller(element, column);
    create_model(element, column);
    create_table(element, column);
    create_permissions(element, column);
    create_route_api(element, column);
    create_js_lists(element, column);
    create_js_item(element, column);
    create_js_edit_item(element, column);
    create_js_new_item(element, column);
    create_js_route_dataservices(element, column);

    return 0;
}
