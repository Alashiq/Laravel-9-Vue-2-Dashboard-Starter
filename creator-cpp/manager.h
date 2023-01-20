#include <iostream>
#include <fstream>
#include <string>
#include <locale>

using namespace std;

struct Column
{
    std::string name;
    std::string type;
    std::string search;
};

struct Element
{
    std::string table;
    std::string model;
    std::string arabicSingle;
    std::string arabic;
    int columnCount;
};

string to_lower(string s) {        
    for(char &c : s)
        c = tolower(c);
    return s;
}



void create_controller(Element element, Column column[20])
{
    std::string sourcePath = "Files/Controller.php";
    std::string destinationPath = element.model + "Controller.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        // Change Class Name
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, element.model);

        // Add Search Filter
        if (data.find("//xSearchColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                if (column[i].search == "y" || column[i].search == "Y")
                {
                    fill = fill + "->where('" + column[i].name + "', 'like', '%' . $request->" + column[i].name + " . '%') \n";
                }
            }
            data.replace(data.find("//xSearchColumn"), 15, fill);
        }


        // Add Colum to Edit Item
        if (data.find("//xEditColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill= fill + "if ($request['" + column[i].name + "'] != null) \n";
                fill= fill + "$item->" + column[i].name + " = $request['" + column[i].name + "']; \n\n";
            }
            data.replace(data.find("//xEditColumn"), 13, fill);
        }


        // Add Colum to Insert Item
        if (data.find("//xInserColumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill = fill + "'" + column[i].name + "' => $request['" + column[i].name + "'], \n";
            }
            data.replace(data.find("//xInserColumn"), 14, fill);
        }

        // Change Arabic Name
        if (data.find("xarabic") != std::string::npos)
            data.replace(data.find("xarabic"), 7, element.arabic);
        if (data.find("xsinglearabic") != std::string::npos)
            data.replace(data.find("xsinglearabic"), 13, element.arabicSingle);

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_model(Element element, Column column[20])
{
    std::string sourcePath = "Files/Model.php";
    std::string destinationPath = element.model + ".php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xmodel") != std::string::npos)
            data.replace(data.find("xmodel"), 6, element.model);

        if (data.find("xcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {
                fill = fill + "'" + column[i].name + "',\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);
        }

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_table(Element element, Column column[20])
{
    // Copy Table File
    std::string sourcePath = "Files/Table.php";
    std::string destinationPath = "create_" + element.table + "_table.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("xtable") != std::string::npos)
            data.replace(data.find("xtable"), 6, element.table);

        if (data.find("xcolumn") != std::string::npos)
        {
            string fill = "";
            for (int i = 0; i < element.columnCount; i++)
            {

                fill = fill + "$table->" + column[i].type + "('" + column[i].name + "');\n";
            }
            data.replace(data.find("xcolumn"), 7, fill);
        }

        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}

void create_permissions(Element element, Column column[20])
{
    std::string sourcePath = "Files/permissions.php";
    std::string destinationPath = "permissions.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("//xpermissions") != std::string::npos)
        {
        string fill = "";
            fill = fill + "// Role " + element.model + "\n";
            fill = fill + "'Read" + element.model + "'=>'Read " + element.table + "', \n";
            fill = fill + "'Create" + element.model + "'=>'Create " + element.table + "', \n";
            fill = fill + "'Edit" + element.model + "'=>'Edit " + element.table + "', \n";
            fill = fill + "'Delete" + element.model + "'=>'Delete " + element.table + "', \n";
            fill = fill + "//xpermissions \n";
            data.replace(data.find("//xpermissions"), 14, fill);
        }
        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}



void create_route_api(Element element, Column column[20])
{
    std::string sourcePath = "Files/api.php";
    std::string destinationPath = "api.php";
    std::ifstream sourceFile(sourcePath, std::ios::binary);
    std::ofstream destinationFile(destinationPath, std::ios::binary);
    std::string data;

    while (std::getline(sourceFile, data))
    {
        if (data.find("#xRoute") != std::string::npos)
        {
            string fill = "# # # # # # # # # # # # # # # # #  "+element.table+"  # # # # # # # # # # # # # # # # #\n";
            fill = fill + "Route::controller("+element.model+"Controller::class)->prefix('"+to_lower(element.model)+"')->group( \n";
            fill = fill + "function () { \n";
            fill = fill + "Route::get('/', ["+element.model+"Controller::class, 'index'])->middleware('check.role:Read"+element.model+"'); \n";
            fill = fill + "Route::delete('/{id}', ["+element.model+"Controller::class, 'delete'])->middleware('check.role:Delete"+element.model+"'); \n";
            fill = fill + "Route::get('/{id}', ["+element.model+"Controller::class, 'show'])->middleware('check.role:Read"+element.model+"'); \n";
            fill = fill + "Route::put('/{id}', ["+element.model+"Controller::class, 'edit'])->middleware('check.role:Edit"+element.model+"'); \n";
            fill = fill + "Route::post('/', ["+element.model+"Controller::class, 'create'])->middleware('check.role:Create"+element.model+"'); \n";
            fill = fill + "} \n";
            fill = fill + "); \n";
            fill = fill + "# # # # # # # # # # # # # # # # # End "+element.table+"  # # # # # # # # # # # # # # #  \n";
            fill = fill + " \n";
            fill = fill + "#xRoute \n";
            data.replace(data.find("#xRoute"), 7, fill);
        }
        destinationFile << data << "\n";
    }

    destinationFile << sourceFile.rdbuf();

    sourceFile.close();
    destinationFile.close();
}